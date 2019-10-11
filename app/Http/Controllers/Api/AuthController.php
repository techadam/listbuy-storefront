<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use App\Service\AuthService;
use App\Service\UserService;
use Illuminate\Http\Request;
use JWTAuth;

class AuthController extends Controller
{
    protected $auth_service;

    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    /**
     * Register A new User
     *
     * @param Request $request
     * @return JSON
     */
    public function register(AuthRegisterRequest $request)
    {
        $validated_data = $request->validated();
        $data = $this->auth_service->registerUser($validated_data, true);

        return $this->success([
            'token' => $data['token'],
            'user' => $data['user'],
        ]);

    }

    /**
     * Authenticate User
     *
     * Uses basic authentication and returns a Json Web Token
     */
    public function login(AuthLoginRequest $request)
    {
        $data = $this->auth_service->loginUser($request->validated());
        if (isset($data['error'])) {
            return $this->notFound($data['error'], $data['data']);
        }
        return $this->success($data);
    }

    /**
     * Refresh Access Token
     *
     * Uses basic authentication and returns a Json Web Token
     */
    public function refresh(Request $request)
    {
        if ($request->header('Authorization')) {
            $token = explode(' ', $request->header('Authorization'))[1];

            $refreshed_token = JWTAuth::refresh($token);
            return $this->success([
                'token' => $refreshed_token,
            ]);
        }
        return $this->badRequest('invalid "Authorization" header');

    }

    /**
     * Verify User's Account
     *
     * Retrieve verification code from the Request and Verify a user's account with it
     */
    public function verify(Request $request, User $user, UserService $user_service)
    {
        $validator = validator($request->all(), [
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->badRequest("OTP required!", $validator->getMessageBag());
        }

        $validated = $validator->validated();

        if ($validated['otp'] == $user->phone_otp) {
            $user = $user_service->updateUserInfo($user, ['verified' => true]);
            return $this->success($user, "User account verified!");
        }

        return $this->badRequest("Invalid OTP entered!");
    }

    public function ChangePassword(Request $request)
    {
        $validator = validator($request->all(), [
            'newPassword' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->badRequest("New Password required!", $validator->getMessageBag());
        }

        $validated = $validator->validated();

        $user = $this->auth_service->UpdatePassword(auth()->user()->username, $validated['newPassword']);
        return $this->success([], 'Password updated successfully!');

    }

}
