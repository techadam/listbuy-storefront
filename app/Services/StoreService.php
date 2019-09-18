<?php

namespace App\Service;

use App\Models\Store;
use App\Models\User;

class StoreService
{
    public function createStore($data, User $user = null)
    {
        $user = $user ? $user : auth()->user();
        $check = $user->store()->get()->first();
        if ($check) {
            return ["status" => false, "message" => "User store already created!"];
        }

        $store = $user->store()->create($data);
        $user->store_id = $store->id;
        $user->save();
        $store->user()->associate($user);
        return tap($store)->save();
    }

    public function updateStore(Store $store, $data)
    {
        return tap($store)->update($data);
    }
}
