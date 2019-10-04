<?php

namespace App\Service;

use App\Helpers\Constants;
use App\Mail\StoreOrderPlaced;
use App\Mail\UserOrderPlaced;
use App\Models\Orders;
use App\Models\PaymentRecords;
use App\Models\Products;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

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
            $payment_record->saveOrFail();

            /* Store order products in DB */
            $order->products()->createMany($order_data['products']);
            /* load relationships */
            $order->load('store', 'payment_record', 'products');

            /* Queue emails */
            Mail::to(["email" => $order->store->email_address])->send(new StoreOrderPlaced(['name' => $order_data['buyer_name']], $order));
            Mail::to(["email" => $order_data['buyer_email']])->send(new UserOrderPlaced($order));

            return collect($order)->except(['products', 'store']);
        } else {
            return ["status" => false, "message" => $payment_res['error']];
        }

    }

    public function getUserOrders($username)
    {
        return Orders::with(['store', 'products'])->whereHas('buyer', function (Builder $query) use ($username) {
            $query->username($username);
        })->paginate(2);
    }

    public function getStoreOrders($store_slug)
    {
        return Orders::with('products')->whereHas('store', function (Builder $query) use ($store_slug) {
            $query->where('slug', $store_slug);
        })->paginate(50);
    }

    /**
     *  Calculates and returns total price of order
     * @param $order
     * @return  int Total price of items
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
