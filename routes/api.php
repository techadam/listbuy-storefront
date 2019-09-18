<?php

use Illuminate\Http\Request;
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


Route::post('/register','Api\AuthController@register');
Route::post('/login','Api\AuthController@login');
Route::post('/verify/{user}','Api\AuthController@verify');

Route::get('/password/verify/{otp}', 'Api\ForgotPasswordController@verifyResetCode');
Route::post('/password/request', 'Api\ForgotPasswordController@sendResetCodeEmail');
Route::post('/password/reset', 'Api\ForgotPasswordController@resetPassword');

Route::namespace('Api')->middleware(['auth.jwt'])->group(function () {
    Route::post('/store', 'StoreController@store');
    Route::put('/store/{store}', 'StoreController@update');

});
