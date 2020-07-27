<?php

namespace App\Data\Repositories\Users;

use App\User;

class UsersRepository implements EloquentRepository
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($input)
    {

        $user = new User($input);

        $user->save();

        return $user;
    }

}

