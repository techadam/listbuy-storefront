<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function UpdatePassword(string $username, $new_password)
    {
        $user = User::where('username', $username)->firstOrFail();
        $user->password = Hash::make($new_password);
        $user->save();
        return $user;
    }
}
