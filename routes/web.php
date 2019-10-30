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
    Route::get('/{store}/product/{slug}', 'StoreController@getProductBySlug');
});
