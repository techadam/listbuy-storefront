<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAuthRegisterRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Service\AuthService;
use App\Service\OrderService;
use App\Service\StoreService;
use App\Service\UserService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Register A new User
     *
     * @param Request $request
     * @return JSON
     */
    public function register(AdminAuthRegisterRequest $request, AuthService $auth_service)
    {

        $validated_data = $request->validated();
        $data = $auth_service->registerUser($validated_data, false);

        return $this->success([
            'token' => $data['token'],
            'user' => $data['user'],
        ]);

    }

    /**
     * Authenticate Admin
     *
     */
    public function login(AuthLoginRequest $request, AuthService $auth_service)
    {
        $data = $auth_service->loginUser($request->validated(), true);
        if (isset($data['error'])) {
            return $this->notFound($data['error'], $data['data']);
        }
        return $this->success($data);
    }

    public function getAllUsers(Request $request, UserService $user_service)
    {
        $users = $user_service->getAllUsers(50, $request->query('role'));
        return $this->success($users);
    }

    public function getAllStores(StoreService $store_service)
    {
        $stores = $store_service->getAllStores();
        return $this->success($stores);
    }

    public function getAllOrders(OrderService $order_service)
    {
        $stores = $order_service->getAllOrders();
        return $this->success($stores);
    }

}
