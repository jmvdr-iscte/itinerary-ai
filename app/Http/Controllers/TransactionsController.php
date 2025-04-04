<?php

namespace App\Http\Controllers;

use App\Gateways\Stripe as Gateway;
use App\Http\Requests\CreateTransactionRequest;
use App\Models\Transaction;
use App\Utils\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Webhook;
use Illuminate\Support\Facades\Mail;
use App\Services\Email;
use App\Models\Itinerary;
use App\Utils\Price;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class TransactionsController extends Controller
{

	final public function getCollection(): JsonResponse
	{
		return response()->json([]);
	}

	final public function getTransaction(string $uid): JsonResponse
	{
	   $transaction = Transaction::where('uid', $uid)->first();

	   if ($transaction === null) {
		   return response()->json([], 404);
	   }

	   return response()->json($transaction->makeHidden(['id', 'itinerary_id', 'product_id', 'promo_code', 'gateway_reference']));
	}

	final public function getTransactionCount(): JsonResponse
	{
        $count = Cache::remember('transaction_count_recent_completed', 60, function () {
            return Transaction::where('status', 'COMPLETED')
                ->where('created_at', '>=', now()->subDay())
                ->count();
        });

		return response()->json(['count' => $count]);
	}

	final public function createTransaction(CreateTransactionRequest $request): JsonResponse
	{
		$gateway = new Gateway();
		$body = $request->validated();

		//check ititnerary_id
		$itinerary = DB::table('itinerary.itinerary')->where('uid', $body['itinerary_uid'])->first();

		if ($itinerary === null) {
			return response()->json(['message' => 'itinerary not found'], 404);
		}

        if (in_array($itinerary->status, ['CANCELED', 'FAILED', 'COMPLETED'], true)) {
			return response()->json(['message' => 'itinerary is already closed'], 400);
        }

		//check product id
		$product = Product::where('uid', $body['product_uid'])->first();

		if ($product === null) {
			return response()->json(['message' => 'product not found'], 404);
		}

		$currency = Currency::isSupportedCurrency($product->currency);

		if (!$currency) {
			return response()->json(['message' => "$currency not supported"], 404);
		}

		//format price
		$formated_product_value = Gateway::normalizePrice($product->value, $product->currency);

		$is_valid = Price::isValidPrice($body['value'], $formated_product_value);

		if ($is_valid) {
			Log::error('Invalid price, possible fraud attempt', ['request' => $body]);
		}

		$transaction = Transaction::create(
			[
				'uid' => Str::uuid(),
				'itinerary_id' => $itinerary->id,
				'product_id' => $product->id,
				'currency' => $product->currency,
				'value' => $formated_product_value,
				'method' => $body['method'],
				'gateway' => $body['gateway'],
				'country' => $body['country'] ?? 'ZZ',
				'promo_code' => $body['promo_code'] ?? null,
				'metadata' => $body['metadata'] ?? [],
				'status' => 'PENDING_PAYMENT'
			]
		);

		$checkout_session = $gateway->executeCheckout($body['success_url'], $body['cancel_url'], $itinerary->id, $transaction, $itinerary->email, $product);
		$info = json_decode($itinerary->itinerary, true);
		//Mail::to($itinerary->email)->send(new Email($info));
		return response()->json([
			'uid' => $transaction->uid,
			'status' => $transaction->status,
			'checkout_session_url' => $checkout_session->url
		], 201);
	}

	final public function handleCallback(Request $request): JsonResponse
	{
		$gateway = new Gateway();
		$payload = $request->getContent();
		$signature = $request->header('Stripe-Signature');

		try {
			$event = Webhook::constructEvent($payload, $signature, env('STRIPE_WEBHOOK_SECRET'));
		} catch (\UnexpectedValueException $e) {
			return response()->json(['error' => 'Invalid payload'], 400);

		} catch (\Stripe\Exception\SignatureVerificationException $e) {
			Log::error('Invalid signature', ['request' => $request->all()]);

			return response()->json(['error' => 'Invalid signature'], 400);
		}

		$session = $event->data->object;

		$transaction_uid = $session->metadata->transaction_uid;
		$itinerary_uid = $session->metadata->itinerary_uid;
		$payment_intent_id = $session->payment_intent;

		if (!isset($session->metadata) || $transaction_uid === null || $itinerary_uid === null) {
			Log::error('Invalid metadata', ['request' => $request->all()]);
			return response()->json(['error' => 'Invalid webhook'], 400);
		}

		$transaction = Transaction::where('uid', $transaction_uid)->first();

		if ($transaction === null) {
			Log::error('Transaction not found', ['transaction_uid' => $transaction_uid]);
			return response()->json(['error' => 'Transaction not found'], 404);
		}

		if (!$transaction->isClosed()) {
			if ($event->type == 'checkout.session.completed') {

				if ($payment_intent_id === null) {
					Log::error('Invalid payment intent', ['request' => $session]);
					return response()->json(['error' => 'Invalid payment intent'], 400);
				}

			   $notification = $gateway->getPaymentNotification($payment_intent_id);
			   if ($transaction->gateway_reference === null) {
					$transaction->gateway_reference = $payment_intent_id;
			   }
			   $transaction->status = Gateway::mapStripeStatusToInternalStatus($notification->status)->value;
			   if ($transaction->status === 'COMPLETED') {
				//fetch itinerary
					$itinerary = Itinerary::where('uid', $itinerary_uid)->first();
					if ($itinerary !== null && !$itinerary->isClosed()) {
						try {
							Mail::to($itinerary->email)->queue(new Email($itinerary->itinerary));
						} catch (\Exception $e) {
							$itinerary->status = 'FAILED';
							$itinerary->save();
							Log::error('Error sending email', ['error' => $e->getMessage()]);
							throw new \Exception('Error sending email');
						}

						$itinerary->status = 'COMPLETED';
						$itinerary->save();
					}
				}
				$transaction->save();
			}
		}

		//return
		return response()->json(['status' => 'success'], 200);
	}
}
