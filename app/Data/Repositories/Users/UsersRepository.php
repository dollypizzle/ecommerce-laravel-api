<?php

namespace App\Data\Repositories\Users;

use App\User;

class UsersRepository implements EloquentRepository
{

    public function register()
    {
        request()->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|',
            'phonenumber' => 'required|numeric',
        ]);

        $user = new User([
            'firstname' => request()->firstname,
            'lastname' => request()->lastname,
            'email' => request()->email,
            'phonenumber' => request()->phonenumber,
            'password' => bcrypt(request()->password),
        ]);

        $user->save();
        return $user;
    }

    public function login()
    {
        request()->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);

        return $credentials;
    }

}

