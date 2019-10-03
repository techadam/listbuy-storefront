<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use App\Notifications\VerificationCode;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Propaganistas\LaravelPhone\PhoneNumber;

class AuthController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function service()
    {
        return $this->service;
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
        $validated_data['password'] = Hash::make($validated_data["password"]);
        $validated_data['phone'] = (string) PhoneNumber::make($validated_data['phone'], $validated_data['country_code']);
        $validated_data['phone_otp'] = mt_rand(1000, 9999);
        $user = User::create($validated_data);
        $user->notify(new VerificationCode($user->phone));

        $token = JWTAuth::fromUser($user);
        return $this->success([
            'id' => $user->id,
            'token' => $token,
            'user' => $user,
        ]);

    }

    /**
     * Authenticate User
     *
     * Uses basic authentication and returns a Json Web Token
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // attempt authorization
        if (!$token = JWTAuth::attempt($credentials)) {
            // authorization failed
            return $this->notFound('Invalid email or password!', $credentials);
        }

        $user_service = new \App\Service\UserService();
        $user = $user_service->getUserInfo(auth()->user()->username, ['store', 'store.bank_details']);
        return $this->success(['token' => $token, 'user' => $user]);
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

}
