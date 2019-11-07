<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Products;
use Cart;
use Cookie;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $url = env('API_URL');
        $client = new \GuzzleHttp\Client();

        //Get product
        $requestProduct = $client->request('GET', $url.'/api/products/'.$request->product_slug);
        $requestProduct = json_decode($requestProduct->getBody());
        $product = $requestProduct->data;

        $qty = preg_replace("#[^0-9]#", "", $request->quantity) !== ""? preg_replace("#[^0-9]#", "", $request->quantity) : 1;
        
        if($product != null) {
            Cart::add($product->id, $product->name, $qty, $product->price, $product->weight, ['image' => $request->product_image]);
        }

        //print_r(Cart::content()); die();
        return back();
    }

    public function update(Request $request) {
        Cart::update($request->rowId, $request->qty);
    }

    public function buy(Request $request)
    {
        $url = env('API_URL');
        $client = new \GuzzleHttp\Client();

        //Get product
        $requestProduct = $client->request('GET', $url.'/api/products/'.$request->product_slug);
        $requestProduct = json_decode($requestProduct->getBody());
        $product = $requestProduct->data;

        $qty = preg_replace("#[^0-9]#", "", $request->quantity) !== ""? preg_replace("#[^0-9]#", "", $request->quantity) : 1;
        
        if($product != null) {
            Cart::add($product->id, $product->name, $qty, $product->price, $product->weight, ['image' => $request->product_image]);
        }
        return redirect('checkout');
    }

    public function remove(Request $request) {
        $rowId = $request->cart_id;
        if(!$rowId) {
            return back();
        }

        Cart::remove($rowId);
        return back()->with([
            'message' => 'Cart item successfully removed'
        ]);
    }

    public function cart()
    {
        $storeCookie = json_decode(Cookie::get('stores'));
        if($storeCookie == null) {
            return redirect('/');
        }
        return view('storefront/cart')->with([
            'store' => $storeCookie,
        ]);
    }

    public function checkout(Request $request)
    {
        if(Cart::count() < 1) {
            return redirect('/cart');
        }
        
        $addressCookie = json_decode(Cookie::get('address'));
        $updateAddressCookie = Cookie::get('updateAddress');
        $storeCookie = json_decode(Cookie::get('store'));
        if($storeCookie == null) {
            return redirect('/');
        }
        
        //Get JSON data
        $jsonString = file_get_contents(base_path('public/data/Countries.json'));
        $data = json_decode($jsonString, true);

        return view('storefront/checkout')->with([
            'address' => $addressCookie,
            'store' => $storeCookie,
            'updateAddress' => $updateAddressCookie,
            'countries' => $data,
        ]);
    }

    public function checkoutAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'lastname' => 'required',
            'firstname' => 'required',
            'dest_address' => 'required',
            'country' => 'required',
            'state' => 'nullable',
            'phone' => 'required',
        ]);
        
        if ($validator->fails()) {
            print_r($validator->errors()); die();
            return back()->withErrors($validator)
                         ->withInput();
        }
        
        Cookie::queue(Cookie::make('address', json_encode($request->all()), 10000000000));
        Cookie::queue(Cookie::make('updateAddress', 'YES', 10000000000));
        return back();
    }

    public function updateAddress(Request $request) {
        Cookie::queue(Cookie::make('updateAddress', 'NO', 10000000000));
        $updateAddressCookie = Cookie::get('updateAddress');
        return back();
    }

    public function orderComplete() {
        Cart::destroy();
        $storeCookie = json_decode(Cookie::get('store'));
        if($storeCookie == null) {
            return redirect('/');
        }
        
        return view('storefront/order-complete')->with([
            'store' => $storeCookie
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
