<?php

namespace App\Gateways;

use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;
use Stripe\Checkout\Session as CheckoutSession;
use App\Enums\Transaction\Status as EStatus;
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
     * @param Transaction $transaction
     * The transaction to execute.
     */
    final public function executeCheckout(string $success_url, string $cancel_url, string $itinerary_id, Transaction $transaction): CheckoutSession
    {
        $client = self::getClient();
        $checkout = $client->checkout->sessions->create([
            'success_url' => $success_url,
            'cancel_url' => $cancel_url,
            'payment_method_types' => [self::processPaymentMethods($transaction->method)],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => $transaction->currency,
                        'product_data' => [
                            'name' => 'Itinerary',
                        ],
                        'unit_amount' => $transaction->value * 100, //TODO: change
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'metadata' => [
                'transaction_id' => $transaction->id,
                'ititnerary_id' => $itinerary_id,
            ]
        ]);

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



    //private functions
    /**
     * Process the payment method.
     *
     * @param string $payment_method
     * The payment method to process.
     *
     * @return string
     * The processed payment method.
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
