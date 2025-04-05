<?php

namespace App\Gateways;

use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;
use Stripe\Checkout\Session as CheckoutSession;
use App\Enums\Transaction\Status as EStatus;
use App\Models\Product;
use Stripe\PaymentIntent;

final class Stripe
{
    /**
     * @var StripeClient|null
     */
    protected $client = null;



    /**
     *  Get the Stripe client.
     *
     * @return StripeClient
     */
    protected function getClient(): StripeClient
    {
        if ($this->client === null) {
            $this->client = new StripeClient([
                'api_key' => env('STRIPE_SECRET_KEY'),
            ]);
        }
        return $this->client;
    }



    /**
     * Execute the checkout.
     *
     * @param string $success_url
     * The success URL.
     *
     * @param string $cancel_url
     * The cancel URL.
     *
     * @param string $itinerary_id
     * The itinerary ID.
     *
     * @param Transaction $transaction
     * The transaction to execute.
     *
     * @param string $email
     * The email to send the receipt to.
     *
     * @return CheckoutSession
     * The checkout session.
     */
    final public function executeCheckout(
        string $success_url,
        string $cancel_url,
        string $itinerary_id,
        Transaction $transaction,
        string $email,
        Product $product
    ): CheckoutSession
    {
        $client = self::getClient();
        $checkout_body = [
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
            'payment_method_types' => [self::processPaymentMethods($transaction->method)],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => $transaction->currency,
                        'product_data' => [
                            'name' => $product->name,
                        ],
                        'unit_amount' => $product->value,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'allow_promotion_codes' => true,
            'metadata' => [
                'transaction_id' => $transaction->id,
                'ititnerary_id' => $itinerary_id,
            ]
        ];
        if ($transaction->method === 'credit_card') {
            $checkout_body['customer_email'] = $email;
        }
        $checkout = $client->checkout->sessions->create($checkout_body);

        return $checkout;
    }

    /**
     * Get the payment notification.
     *
     * @param string $payment_intent
     * The payment intent to get.
     *
     * @throws \Exception
     *
     * @return \Stripe\PaymentIntent
     * The payment intent.
     */
    final public function getPaymentNotification(string $payment_intent): PaymentIntent
    {
        $client = self::getClient();

        try{
            $payment = $client->paymentIntents->retrieve($payment_intent);
        } catch (\Exception $e) {
            Log::error('Invalid payment intent', ['payment_intent' => $payment]);
            throw new \Exception('Invalid payment intent');
        }
        return $payment;
    }


    //public static functions
    /**
     * Map the Stripe status to the internal status.
     *
     * @param string $stripeStatus
     * The Stripe status to map.
     *
     * @return EStatus
     * The internal status.
     */
    public static function mapStripeStatusToInternalStatus(string $stripeStatus): EStatus
    {
        return match ($stripeStatus) {
            'requires_payment_method' => EStatus::PENDING_PAYMENT,
            'requires_confirmation' => EStatus::PENDING_PAYMENT,
            'requires_action' => EStatus::PENDING_PAYMENT,
            'processing' => EStatus::PROCESSING,
            'requires_capture' => EStatus::PROCESSING,
            'succeeded' => EStatus::COMPLETED,
            'canceled' => EStatus::CANCELED,
            default => EStatus::FAILED,

        };
    }

    /**
     * Normalize the price based on the currency.
     *
     * @param int $price
     * The price to normalize.
     *
     * @param string $currency
     * The currency to normalize to.
     *
     * @return string
     * The normalized price.
     */
    public static function normalizePrice(int $price, string $currency): string
    {
        return match($currency) {
            'USD' => number_format($price, 2, '.', ''),
            'EUR' => number_format($price, 2, ',', ''),
            'GBP' => number_format($price, 2, ',', ''),
            default => number_format($price, 2, '.', ''),
        };
    }



    //private functions
    /**
     * Process the payment method.
     *
     * @param string $payment_method
     * The payment method to process.
     *
     * @return string
     * The processed payment method.
     *
     * @throws \Exception
     */
    private function processPaymentMethods(string $payment_method): string
    {
        switch($payment_method) {
            case 'credit_card':
                return 'card';
            case 'paypal':
                return 'paypal';
            default:
                throw new \Exception('Invalid payment method');
        }
    }
}
