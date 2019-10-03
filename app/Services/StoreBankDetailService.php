<?php

namespace App\Service;

use App\Models\Store;
use Illuminate\Support\Facades\DB;

class StoreBankDetailService
{
    public function saveStoreBankDetails(Store $store, $bank_details)
    {
        return $store->bank_details()->create($bank_details);
    }

    public function updateStoreBankDetails(Store $store, $bank_details)
    {

        $store->bank_details()->update($bank_details);
        return $store->bankDetails->fresh();
    }
}
