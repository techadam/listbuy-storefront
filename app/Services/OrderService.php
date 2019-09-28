<?php

namespace App\Service;

use App\Helpers\Constants;
use App\Models\Orders;
use App\Models\PaymentRecords;
use App\Models\Products;

class OrderService
{
    public function processOrder($order_data)
    {
        $order_data['total_price'] = $this->calculateTotalPrice($order_data);
        $payment_service = $this->getPaymentProcessorService($order_data['payment_method']);
        $payment_res = $payment_service->processPayment($order_data);

        if (isset($payment_res['status']) && $payment_res['status'] == "paid") {
            $payment_record = new PaymentRecords($payment_res);
            $payment_record->store()->associate($order_data['store_id']);
            $payment_record->buyer()->associate(auth()->user());
            $payment_record->saveOrFail();

            $order_data['generated_id'] = substr(base_convert(md5($payment_record['reference_id']), 16, 32), 0, 12);
            $order_data['user_id'] = auth()->id();
            $order_data['payment_record_id'] = $payment_record['id'];

            $order = Orders::create($order_data);

            /* update payment record with order_id */
            $payment_record->order()->associate($order);
            $payment_record->save();

            /* Store order products in DB */
            $order->products()->createMany($order_data['products']);

            return $order->load('payment_record');
        }

    }


    /**
     *  Calculates and returns total price of order
     *  @return  int Total price of items
     */
    private function calculateTotalPrice($order)
    {
        $total_price = 0;
        foreach ($order['products'] as $product) {
            $product_model = Products::where('id', $product['product_id'])->first(['price']);
            $total_price += ($product_model['price'] * $product['quantity']);
        }
        return $total_price;
    }

    private function getPaymentProcessorService($payment_method)
    {
        $payment_service = null;
        switch ($payment_method) {
            case Constants::STRIPE_PAYMENT;
                $payment_service = new StripePaymentService();
                break;

            default:
                false;
                break;
        }

        return $payment_service;
    }
}