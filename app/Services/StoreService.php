<?php

namespace App\Service;

use App\Models\Store;
use App\Models\StoreImages;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use JD\Cloudder\Facades\Cloudder;

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
        if (isset($data['logo'])) {
            Cloudder::upload($data['logo'], null, array("use_filename" => true, "folder" => env('PRODUCT_LISTING_IMAGE_CLOUD_PATH')));
            $store->logo()->save(new StoreImages(['url' => Cloudder::getResult()['secure_url'], 'cloudinary_id' => Cloudder::getResult()['public_id']]));
        }

        $user->store_id = $store->id;
        $user->save();
        $store->owner()->associate($user);
        $store->save();
        return $store->fresh('logo');
    }

    public function updateStore(Store $store, $data)
    {
        if (isset($data['logo'])) {
            Cloudder::upload($data['logo'], null, array("use_filename" => true, "folder" => env('PRODUCT_LISTING_IMAGE_CLOUD_PATH')));
            StoreImages::updateOrCreate(['store_id' => $store->id], ['url' => Cloudder::getResult()['secure_url'], 'cloudinary_id' => Cloudder::getResult()['public_id']]);
        }

        $store->update($data);
        return $store->fresh('logo');
    }

    public function getStoreProducts(Store $store, $params = false, $limit = 50)
    {
        if(isset($params['min_price']) && isset($params['max_price'])){
            $product_service = new \App\Service\ProductsService();
            return $product_service->filterProductsByPrice($params['min_price'],$params['max_price'],$store->id);
        }
        return $store->products()->paginate($limit);
    }

    public function getUserStore($username)
    {
        return Store::with('bank_details')->whereHas('owner', function (Builder $query) use ($username) {
            $query->username($username);
        })->first();

    }

    public function getStore($slug)
    {
        return Store::with(['owner'])->where('slug', $slug)->first();
    }

    public function getAllStores($limit = 50)
    {
        return Store::with(['owner'])->paginate($limit);
    }
}
