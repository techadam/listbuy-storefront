<?php

namespace App\Http\Controllers\Store;

use App\Models\Store;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\StoreService;

class StoreController extends Controller
{
    protected $store_service;
    public function __construct(StoreService $store_service)
    {
        $this->store_service = $store_service;
    }

    public function index()
    {
        return view('storefront/index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
    }

    public function getProductBySlug($store, $slug)
    {
        $prodstore = Store::where('slug', $store)->get()[0];
        $similar = Products::where('store_id', $prodstore->id)->where('slug', '<>', $slug)->limit(4)->orderBy('id', 'desc')->get();
        $product = Products::where('slug', $slug)->get()[0];
        return view('storefront/product')->with([
            'store' => $prodstore,
            'products' => $similar,
            'product' => $product,
        ]);
    }

    public function getUserStore(Request $request)
    {
        $store = $this->store_service->getUserStore($request->user()->username);
        return dd($store);
    }

    public function getStoreDetails(Store $storeObj, $slug)
    {
        $store = Store::where('slug', $slug)->get()[0];
        $products = Products::where('store_id', $store->id)->paginate(12);
        return view('storefront/store')->with([
            'store' => $store,
            'products' => $products,
        ]);
    }
}
