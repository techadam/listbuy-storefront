<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use App\Service\StoreService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStoreRequest;
use App\Http\Requests\StoreCreationRequest;

class StoreController extends Controller
{
    protected $store_service;
    public function __construct(StoreService $store_service)
    {
        $this->store_service = $store_service;
    }

    public function store(StoreCreationRequest $request)
    {
        $store = $this->store_service->createStore($request->validated());
        if (isset($store['status']) && !$store['status']) {
            return $this->badRequest($store['message']);
        }
        return $this->created($store, "Store created");
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $store = $this->store_service->updateStore($store, $request->validated());
        return $this->success($store, "Store updated");
    }
}
