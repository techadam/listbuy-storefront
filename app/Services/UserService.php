<?php

namespace App\Service;

use App\Models\User;

class UserService
{
    public function updateUserInfo(User $user, $data)
    {
        return tap($user)->update($data);
    }

    public function getUserInfo($username, $with = [])
    {
        return User::with($with)->where('username', $username)->firstOrFail();
    }
}
