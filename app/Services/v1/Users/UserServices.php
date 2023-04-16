<?php

namespace App\Services\v1\Users;

use App\Models\User;

class UserServices
{
    public function fetch(Int $user_id, array $select = ['*'])
    {
        $user = User::find($user_id, $select);

        return $user;
    }
}
