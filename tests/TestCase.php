<?php

namespace Tests;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp():void
    {
        parent::setUp();

        \Artisan::call('passport:install');

        $this->user = create('App\User');

        $this->withoutExceptionHandling();

    }

    protected function signIn($user = null)
    {
        $user = create('App\User');

        //$user = factory('App\User')->create();
        $token = $user->createAccessToken($user);
        $header = ['Authorization' => "Bearer $token"];

        // $this->actingAs($token);

        return $header;
    }

}
