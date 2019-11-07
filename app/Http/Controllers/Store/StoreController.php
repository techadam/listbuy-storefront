<?php

namespace App\Http\Controllers\Store;

use App\Models\Store;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\StoreService;
use Cookie;
use Cart;

class StoreController extends Controller
{
    public function index()
    {
        return view('storefront/index')->with([
            'message' => ''
        ]);
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
        $url = env('API_URL');
        $storeCookie = json_decode(Cookie::get('store'));

        $client = new \GuzzleHttp\Client();

        //Get store
        $requestStore = $client->request('GET', $url.'/api/stores/'.$store);
        $responseStore = json_decode($requestStore->getBody());
        
        $prodstore = $responseStore->data;

        if($storeCookie == null || $storeCookie == "" || $storeCookie == $slug) {
            Cookie::queue(Cookie::make('stores', json_encode($prodstore), 10000000000));
        }
        
        if($prodstore != null) {
            if($storeCookie != null && $storeCookie->slug != $prodstore->slug) {
                Cart::destroy();
            }
            Cookie::queue(Cookie::make('stores', json_encode($prodstore), 10000000000));
        }

        //Get product
        $requestProduct = $client->request('GET', $url.'/api/products/'.$slug);
        $requestProduct = json_decode($requestProduct->getBody());
        
        $similar = [];
        $product = $requestProduct->data;

        return view('storefront/product')->with([
            'store' => $prodstore,
            'products' => $similar,
            'product' => $product,
        ]);
    }

    public function getStoreDetails(Store $storeObj, $slug)
    {
        $url = env('API_URL');
        $storeCookie = json_decode(Cookie::get('store'));

        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET', $url.'/api/stores/'.$slug.'/products');
        $response = json_decode($request->getBody());

        $requestStore = $client->request('GET', $url.'/api/stores/'.$slug);
        $responseStore = json_decode($requestStore->getBody());
        
        $products = $response->data->data;
        $store = $responseStore->data;

        if($storeCookie == null || $storeCookie == "" || $storeCookie == $slug) {
            Cookie::queue(Cookie::make('stores', json_encode($store), 10000000000));
        }

        if($store != null) {
            if($storeCookie != null && $storeCookie->name != $store->name ) {
                Cart::destroy();
            }
            Cookie::queue(Cookie::make('store', json_encode($store), 10000000000));
        }
        
        return view('storefront/store')->with([
            'store' => $store,
            'products' => $products,
        ]);
    }

    public function findStore(Request $request) {
        $url = env('API_URL');
        $slug = $request->search;
        if($slug != '') {
            $client = new \GuzzleHttp\Client();
            $requestStore = $client->request('GET', $url.'/api/stores/'.$slug);
            $responseStore = json_decode($requestStore->getBody());
            $store = $responseStore->data;

            if($store != null) {
                Cookie::queue(Cookie::make('store', json_encode($store), 10000000000));
                return redirect('/stores/'.$slug);
            }else{
                return back()->with('message', 'Store not found');
            }
        }else{
            return back()->with('message', 'Store slug field required');
        }
        
        return back()->with('message', 'Store not found');
    }
}
