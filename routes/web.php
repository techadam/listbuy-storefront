<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace ('Store')->group(function() {
    Route::get("/", 'StoreController@index');

    Route::prefix('stores')->group(function () {
        Route::get('/{store}', 'StoreController@getStoreDetails');
    });
    Route::post('/find-store', 'StoreController@findStore');
    Route::get('/{store}/product/{slug}', 'StoreController@getProductBySlug');
    Route::post('/cart/add', 'CartController@add');
    Route::post('/cart/update', 'CartController@update');
    Route::post('/cart/buy', 'CartController@buy');
    Route::post('/cart/remove', 'CartController@remove');
    Route::get('/cart', 'CartController@cart');
    Route::get('/checkout', 'CartController@checkout');
    Route::post('/checkout-address', 'CartController@checkoutAddress');
    Route::post('/checkout-address-update', 'CartController@updateAddress');
    Route::get('/order-complete', 'CartController@orderComplete');
});
