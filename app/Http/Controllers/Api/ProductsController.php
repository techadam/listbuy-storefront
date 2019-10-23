<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductImages;
use App\Models\Products;
use App\Service\ProductsService;

class ProductsController extends Controller
{
    protected $product_service;
    public function __construct(ProductsService $product_service)
    {
        $this->product_service = $product_service;
    }

    public function addProduct(AddProductRequest $request)
    {
        $product = $this->product_service->addProduct($request->validated());
        return $this->created($product, 'Product added to store successfully');
    }

    public function getProduct($slug)
    {
        $product_data = $this->product_service->getProduct($slug);
        return $this->success($product_data);
    }

    public function updateProduct(UpdateProductRequest $request, Products $product)
    {
        $product_data = $this->product_service->updateProduct($product, $request->validated());
        return $this->success($product_data, "Product updated successfully!");
    }

    public function getProducts()
    {
        $product_data = $this->product_service->getAllProducts();
        return $this->success($product_data);
    }

    public function deleteProduct($product_slug)
    {
        $product_data = $this->product_service->deleteProduct($product_slug);
        return $this->success($product_data, "$product_slug deleted successfully!");
    }

    public function deleteProductImage(ProductImages $product_image)
    {
        $res = $this->product_service->deleteProductImage($product_image);
        if (!$res) {
            return $this->badRequest("Failed to delete Product Image!");
        }
        return $this->success($res, "Product Image deleted successfully!");
    }

    public function getActiveStoresProducts()
    {
        $product_data = $this->product_service->getAllActiveStoresProducts();
        return $this->success($product_data);
    }
}
