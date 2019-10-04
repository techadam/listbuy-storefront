<?php

namespace App\Service;

use App\Helpers\Constants;
use App\Interfaces\PaymentServiceInterface;
use Stripe\Charge;
use Stripe\Stripe;

class StripePaymentService implements PaymentServiceInterface
{
    public function processPayment($order_data)
    {
        $response = $this->contactApiProvider($order_data);

        if (isset($response->status) && $response->status == "succeeded") {
            $data['status'] = "paid";
            $data['reference_id'] = $response->id;
            $data['amount'] = $response->amount;
            $data['currency'] = $response->currency;
            $data['payment_processor'] = Constants::STRIPE_PAYMENT;
            $data['payment_method'] = $response->payment_method;

            return $data;

        } else {
            return ["error" => $response['error'], 'status' => "failed"];
        }
    }

    public function contactApiProvider($order_data)
    {
        try {
            $key = env('APP_ENV') == "local" ? env('STRIPE_TEST_KEY') : env('STRIPE_LIVE_KEY');
            Stripe::setApiKey($key);
            /* TODO: check for amount calculation */
            $charge = Charge::create(['amount' => ($order_data['total_price'] * 100), 'currency' => $order_data['currency'] ? $order_data['currency'] : 'usd', 'source' => $order_data['stripe_source']]);
            return $charge;
        } catch (\Exception $error) {
            return ['error' => $error->getMessage()];
        }
    }
}
