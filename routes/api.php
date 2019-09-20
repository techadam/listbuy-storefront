<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::post('/verify/{user}', 'Api\AuthController@verify');

Route::get('/password/verify/{otp}', 'Api\ForgotPasswordController@verifyResetCode');
Route::post('/password/request', 'Api\ForgotPasswordController@sendResetCodeEmail');
Route::post('/password/reset', 'Api\ForgotPasswordController@resetPassword');

Route::namespace ('Api')->middleware(['auth.jwt'])->group(function () {
    Route::post('/store', 'StoreController@store');
    Route::put('/store/{store}', 'StoreController@update');
    Route::get('/store/{store}/products', 'StoreController@getStoreProducts');

    Route::post('/product', 'ProductsController@addProduct');
    Route::get('/products', 'ProductsController@getProducts');
    Route::get('/products/active', 'ProductsController@getActiveStoresProducts');
    Route::get('/product/{slug}', 'ProductsController@getProduct');
    Route::put('/product/{product}', 'ProductsController@updateProduct');

});
