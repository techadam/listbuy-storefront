<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Service\UserService;

class UserController extends Controller
{
    protected $user_service;
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function updateUserDetails(UpdateUserRequest $request, User $username)
    {
        $user = $this->user_service->updateUserInfo($username, $request->validated());
        return $this->success($user, 'User info updated successfully');

    }
}
