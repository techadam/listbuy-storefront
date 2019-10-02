<?php

namespace App\Service;

use App\Models\Products;
use Illuminate\Database\Eloquent\Builder;
use JD\Cloudder\Facades\Cloudder;

class ProductsService
{

    /**
     * TODO: update query to use transactions
     */
    public function addProduct($product, User $user = null)
    {
        $user = $user ? $user : auth()->user();
        $store = $user->store()->get()->first();

        $product_model = $store->products()->create($product);
        $images = [];

        for ($i = 0; $i < count($product['images']); $i++) {
            Cloudder::upload($product['images'][$i], null, array("use_filename" => true, "folder" => env('PRODUCT_LISTING_IMAGE_CLOUD_PATH')));
            array_push($images, ['url' => Cloudder::getResult()['secure_url']]);
        }

        $product_model->images()->createMany($images);
        return Products::where('id', $product_model->id)->first();
    }

    public function getProduct($product_slug)
    {
        return Products::with('store')->where('slug', $product_slug)->first();
    }

    public function getAllActiveStoresProducts($limit = 50)
    {
        return Products::whereHas('store', function (Builder $query) {
            $query->active();
        })->paginate($limit);
    }

    public function getAllProducts($limit = 50)
    {
        return Products::with('store')->paginate($limit);
    }

    public function updateProduct(Products $product, $data)
    {
        return tap($product)->update($data);
    }
}
