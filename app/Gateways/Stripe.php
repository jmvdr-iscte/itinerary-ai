<?php

namespace App\Gateways;

use App\Models\Transaction;
use Google\Service\BinaryAuthorization\Check;
use Stripe\StripeClient;
use Stripe\Checkout\Session as CheckoutSession;


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
