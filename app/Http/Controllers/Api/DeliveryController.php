<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryPriceRequest;
use App\Service\DeliveryService;

class DeliveryController extends Controller
{
    protected $delivery_service;
    public function __construct(DeliveryService $delivery_service)
    {
        $this->delivery_service = $delivery_service;
    }

    public function getDeliveryPrice(DeliveryPriceRequest $request)
    {
        $tariff_model = $this->delivery_service->getDeliveryPrice($request->validated());
        return $this->success($tariff_model);
    }

    public function getDeliveryStates()
    {
        $states = $this->delivery_service->getDeliveryStates();
        return $this->success($states);
    }
}
