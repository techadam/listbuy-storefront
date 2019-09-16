<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register','Api\AuthController@register');
Route::post('/login','Api\AuthController@login');
Route::post('/verify/{user}','Api\AuthController@verify');

Route::get('/password/verify/{otp}', 'API\ForgotPasswordController@verifyResetCode');
Route::post('/password/request', 'API\ForgotPasswordController@sendResetCodeEmail');
Route::post('/password/reset', 'API\ForgotPasswordController@resetPassword');

