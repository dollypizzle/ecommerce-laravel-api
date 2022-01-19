<?php

namespace App\Data\Repositories\Users;


interface EloquentRepository
{
    public function register();

    public function login();
}
