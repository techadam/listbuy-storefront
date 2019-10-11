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

Route::namespace ('Api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', 'AuthController@register');
        Route::post('/login', 'AuthController@login');
        Route::post('/verify/{user}', 'AuthController@verify');

        Route::get('/password/verify/{otp}', 'ForgotPasswordController@verifyResetCode');
        Route::post('/password/request', 'ForgotPasswordController@sendResetCodeEmail');
        Route::post('/password/reset', 'ForgotPasswordController@resetPassword');
    });

    Route::prefix('product')->group(function () {
        Route::get('/{slug}', 'ProductsController@getProduct');
    });

    Route::prefix('store')->group(function () {
        Route::get('/{store}', 'StoreController@getStoreDetails');
        Route::get('/{store}/products', 'StoreController@getStoreProducts');
    });

    Route::prefix('delivery')->group(function () {
        Route::get('/price', 'DeliveryController@getDeliveryPrice');
        Route::get('/states', 'DeliveryController@getDeliveryStates');
    });

    Route::prefix('order')->group(function () {
        Route::post('/process', 'OrdersController@processOrder');
    });

    /* Authenticated routes */
    Route::middleware(['auth.jwt'])->group(function () {
        Route::prefix('auth')->group(function () {
            Route::put('/password/change', 'AuthController@ChangePassword');
        });

        Route::prefix('user')->group(function () {
            Route::put('/{username}', 'UserController@updateUserDetails');
        });

        Route::prefix('store')->group(function () {
            Route::get('/user/me', 'StoreController@getUserStore');
            Route::post('/', 'StoreController@store');
            Route::put('/{store}', 'StoreController@update');
            Route::post('{store}/bank', 'StoreBankDetailsController@saveUserStoreBankDetails');
            Route::put('{store}/bank', 'StoreBankDetailsController@updateUserStoreBankDetails');
            Route::get('me/orders/', 'OrdersController@getAuthStoreOrders');
        });

        Route::prefix('product')->group(function () {
            Route::post('/', 'ProductsController@addProduct');
            Route::put('/{product}', 'ProductsController@updateProduct');
            Route::delete('/{slug}', 'ProductsController@deleteProduct');
        });

        Route::prefix('products')->group(function () {
            Route::get('/', 'ProductsController@getProducts');
            Route::get('/active', 'ProductsController@getActiveStoresProducts');
        });

        Route::prefix('orders')->group(function () {
            Route::get('/me', 'OrdersController@getUserOrders');
        });

        Route::prefix('import')->group(function () {
            Route::post('/states', 'ImportController@importStates');
            Route::post('/delivery/zone/tariff', 'ImportController@importZoneTariff');
            Route::post('/delivery/zones', 'ImportController@importDeliveryZones');
            Route::post('/delivery/weight', 'ImportController@importDeliveryWeight');
            Route::post('/delivery/tariffs', 'ImportController@importDeliveryTariffs');
        });

    });

});

/* Admin routes */
Route::namespace ('Api')->prefix('admin')->group(function () {
    Route::post('/register', 'AdminController@register');
    Route::post('/login', 'AdminController@login');

    Route::group(['middleware' => ['auth.jwt', 'auth.admin']], function () {
        Route::get('/users', 'AdminController@getAllUsers');
        Route::get('/stores', 'AdminController@getAllStores');
        Route::get('/orders', 'AdminController@getAllOrders');
    });

});
