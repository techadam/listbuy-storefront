<?php

namespace App\Service;

use App\Models\User;

class UserService
{
    public function updateUserInfo(User $user, $data)
    {
        return tap($user)->update($data);
    }
}
