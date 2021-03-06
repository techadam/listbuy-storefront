<?php

namespace App\Http\Controllers\Api;

use App\Models\Orders;
use Illuminate\Http\Request;
use App\Service\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\ProcessOrderRequest;

class OrdersController extends Controller
{

    protected $order_service;
    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;
    }

    public function processOrder(ProcessOrderRequest $request)
    {
        $order = $this->order_service->processOrder($request->validated());
        if (isset($order['error'])) {
            return $this->custom($order, $order['error'], false, 500);
        }
        return $this->created($order, "Order successfully placed!");
    }

    public function getUserOrders(Request $request)
    {
        $orders = $this->order_service->getUserOrders($request->user()->username);
        return $this->success($orders);
    }

    public function updateOrder(UpdateOrderRequest $request, Orders $order)
    {
        $order = $this->order_service->updateOrders($order, $request->validated());
        return $this->success($order);
    }

    public function getAuthStoreOrders(Request $request)
    {
        $orders = $this->order_service->getStoreOrders($request->user()->store->slug);
        return $this->success($orders);
    }

}
