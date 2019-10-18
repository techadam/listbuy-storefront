<?php

namespace App\Service;

use App\Mail\UserRegistrationMail;
use App\Models\User;
use App\Notifications\VerificationCode;
use App\Service\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Propaganistas\LaravelPhone\PhoneNumber;

class AuthService
{
    protected $user_service;
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    /**
     * Registers a user
     * @return User $user
     */
    public function registerUser(array $user_data, bool $to_verify)
    {
        $user_data['password'] = Hash::make($user_data["password"]);
        $user_data['phone'] = (string) PhoneNumber::make($user_data['phone'], $user_data['country_code']);
        $user_data['phone_otp'] = mt_rand(1000, 9999);
        $user = User::create($user_data);
        if ($to_verify) {
            $user->notify(new VerificationCode($user->phone));
        }
        $token = JWTAuth::fromUser($user);
        Mail::to(["email" => $user->email])->send(new UserRegistrationMail());

        return ['user' => $user, 'token' => $token];
    }

    /**
     * Registers a user
     * @return User $user
     */
    public function loginUser(array $input, $is_admin = false)
    {
        if (\is_numeric($input['email_phone'])) {
            $credentials['phone'] = $input['email_phone'];
        } else {
            $credentials['email'] = $input['email_phone'];
        }
        $credentials['password'] = $input['password'];
        if ($is_admin) {
            $credentials['role'] = 'admin';
        }
        // attempt authorization
        if (!$token = JWTAuth::attempt($credentials)) {
            // authorization failed
            return ["error" => "Invalid credentials entered!", "data" => $credentials];
        }

        $data['user'] = $this->user_service->getUserInfo(auth()->user()->username, ['store', 'store.bank_details']);
        $data['token'] = $token;
        return $data;
    }

    public function UpdatePassword(string $username, $new_password)
    {
        $user = User::where('username', $username)->firstOrFail();
        $user->password = Hash::make($new_password);
        $user->save();
        return $user;
    }

    public function refreshToken(string $oldToken)
    {
        $newToken = JWTAuth::refresh($oldToken);
        return $newToken;
    }
}
