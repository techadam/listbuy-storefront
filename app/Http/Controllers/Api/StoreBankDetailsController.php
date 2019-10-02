<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBankDetailsRequest;
use App\Http\Requests\UpdateBankDetailsRequest;
use App\Models\Store;
use App\Service\StoreBankDetailService;

class StoreBankDetailsController extends Controller
{
    protected $store_bank_detail_service;

    public function __construct(StoreBankDetailService $store_bank_detail_service)
    {
        $this->store_bank_detail_service = $store_bank_detail_service;
    }

    public function saveUserStoreBankDetails(AddBankDetailsRequest $request, Store $store)
    {
        $bank_details = $this->store_bank_detail_service->saveStoreBankDetails($store, $request->validated());
        return $this->created($bank_details, 'Store bank details added successfully!');
    }

    public function updateUserStoreBankDetails(UpdateBankDetailsRequest $request, Store $store)
    {
        $bank_details = $this->store_bank_detail_service->updateStoreBankDetails($store, $request->validated());
        return $this->success($bank_details, 'Store bank details updated successfully!');
    }
}
