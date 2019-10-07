<?php

namespace App\Service;

use App\Models\Products;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
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
            array_push($images, ['url' => Cloudder::getResult()['secure_url'], 'cloudinary_id' => Cloudder::getResult()['public_id']]);
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
        if (isset($data['images'])) {
            $images = [];
            for ($i = 0; $i < count($data['images']); $i++) {
                Cloudder::upload($data['images'][$i], null, array("use_filename" => true, "folder" => env('PRODUCT_LISTING_IMAGE_CLOUD_PATH')));
                array_push($images, ['url' => Cloudder::getResult()['secure_url'], 'cloudinary_id' => Cloudder::getResult()['public_id']]);
            }
            $product->images()->createMany($images);
        }
        $product->update($data);
        return $product->load('images');
    }

    public function deleteProduct($product_slug)
    {
        $product = Products::where('slug', $product_slug)->firstOrFail();
        $cloudinaryIds = Arr::pluck($product->images, 'cloudinary_id');
        if (isset($cloudinaryIds) && count($cloudinaryIds)) {
            Cloudder::destroyImages($cloudinaryIds);
        }
        $product->images()->delete();
        return $product->delete();
    }

}
