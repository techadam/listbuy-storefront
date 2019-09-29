<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessOrderRequest;
use App\Service\OrderService;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->created($order, "Order successfully placed!");
    }

    public function getUserOrders(Request $request)
    {
        $orders = $this->order_service->getUserOrder($request->user()->username);
        return $this->success($orders);
    }

}
