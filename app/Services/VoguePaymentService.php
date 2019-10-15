<?php

namespace App\Service;

use App\Helpers\Constants;
use App\Interfaces\PaymentServiceInterface;
use Unirest\Request;

class VoguePaymentService implements PaymentServiceInterface
{
    public function processPayment($order_data)
    {
        $response = $this->contactApiProvider($order_data);
        if (isset($response->status) && $response->status == "Approved") {
            $data['status'] = "paid";
            $data['reference_id'] = $response->transaction_id;
            $data['amount'] = $response->total;
            $data['currency'] = $response->cur_iso;
            $data['payment_processor'] = Constants::VOGUE_PAYMENT;
            $data['payment_method'] = $response->method;

            return $data;

        } else {
            return ["error" => $response->ERROR, 'status' => "failed"];
        }
    }

    public function contactApiProvider($order_data)
    {
        try {
            if (\env('APP_ENV') == "production") {
                $url = "https://voguepay.com/?v_transaction_id={$order_data['reference_id']}&type=json";
            } else {
                $url = "https://voguepay.com/?v_transaction_id={$order_data['reference_id']}&type=json&demo=true";
            }

            $headers = array('Content-Type' => 'application/json');
            $response = Request::get($url, $headers);
            return $response->body;

        } catch (\Exception $error) {
            return ["error" => $error];
        }

    }

}
