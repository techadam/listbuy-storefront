<?php

namespace App\Service;

use App\Models\User;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;

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
        $store->owner()->associate($user);
        return tap($store)->save();
    }

    public function updateStore(Store $store, $data)
    {
        return tap($store)->update($data);
    }

    public function getStoreProducts(Store $store, $limit = 50)
    {
        return $store->products()->paginate($limit);
    }

    public function getUserStore($username)
    {
        return Store::whereHas('owner', function (Builder $query) use ($username) {
            $query->username($username);
        })->first();

    }
}
