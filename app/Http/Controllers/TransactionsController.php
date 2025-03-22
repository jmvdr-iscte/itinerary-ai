<?php

namespace App\Http\Controllers;

use App\Gateways\Stripe;
use App\Http\Requests\CreateTransactionRequest;
use App\Models\Transaction;
use App\Utils\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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



	final public function createTransaction(CreateTransactionRequest $request): JsonResponse
	{
		$gateway= new Stripe();
		$body = $request->validated();

		//check ititnerary_id
		$itinerary = DB::table('itinerary.itinerary')->where('uid', $body['itinerary_uid'])->first();
		if ($itinerary=== null) {

			//create error response
			return response()->json([404]);
		}

		//check product id
		$product= DB::table('transactions.products')->where('uid', $body['product_uid'])->first();

		if ($product === null) {
			//create error response
			return response()->json([404]);
		}

		//TODO: validate currency
		$currency = Currency::isSupportedCurrency($body['currency']);

		if (!$currency) {
			//create error response
			return response()->json([400]);
		}
		//TODO: verify promo code

		$transaction = Transaction::create(
			[
				'uid' => Str::uuid(),
				'itinerary_id' => $itinerary->id,
				'product_id' => $product->id,
				'currency' => $body['currency'],
				'value' => $body['value'],
				'method' => $body['method'],
				'gateway' => $body['gateway'],
				'country' => $body['country'] ?? 'ZZ',
				'promo_code' => $body['promo_code'] ?? null,
				'metadata' => $body['metadata'] ?? [],
				'status' => 'PENDING_PAYMENT'
			]);

		$checkout_session = $gateway->executeCheckout($body['success_url'], $body['cancel_url'], $itinerary->id, $transaction);


		return response()->json([
            'uid' => $transaction->uid,
            'status' => $transaction->status,
            'checkout_session_url' => $checkout_session->url
        ], 201);
	}

	final public function handleCallback(Request $request): JsonResponse
	{
		return response()->json([]);
	}
}
