<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;
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
        return $this->success($product_data, "Product updated sucessfully!");
    }

    public function getProducts()
    {
        $product_data = $this->product_service->getAllProducts();
        return $this->success($product_data);
    }

    public function getActiveStoresProducts()
    {
        $product_data = $this->product_service->getAllActiveStoresProducts();
        return $this->success($product_data);
    }
}
