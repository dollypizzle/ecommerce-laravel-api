<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_requires_a_firstname()
    {
        $this->publishUser(['firstname' => null])
            ->assertSessionHasErrors('firstname');
    }

    /** @test */
    function a_user_requires_a_lastname()
    {
        $this->publishUser(['lastname' => null])
            ->assertSessionHasErrors('lastname');
    }

    /** @test */
    function a_user_requires_a_email()
    {
        $this->publishUser(['email' => null])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    function a_user_requires_a_password()
    {
        $this->publishUser(['password' => null])
            ->assertSessionHasErrors('password');
    }

    /** @test */
    function a_user_requires_a_phonenumber()
    {
        $this->publishUser(['phonenumber' => null])
            ->assertSessionHasErrors('phonenumber');
    }

    /** @test */
    function a_user_can_login()
    {
        create('App\User', [
            'email' => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);

        $input = [
            'email' => 'testlogin@user.com',
            'password' => 'toptal123'
        ];

        $this->post(route('login'), [
            'email' => 'john@topl.com',
            'password' => 'topt123',
        ])->assertStatus(401);

        $this->json('POST', 'api/login', $input)
            ->assertStatus(200);
    }

    /** @test */
    function a_guest_can_register()
    {
        $input = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'john@toptal.com',
            'password' => 'toptal123',
            'phonenumber' => '58858494',
        ];

        $this->json('post', '/api/register', $input)
            ->assertStatus(200);
    }

    /** @test */
    function a_user_can_logout()
    {
        $header = $this->signIn();

        $this->json('post', '/api/logout', [], $header)
            ->assertStatus(200);
    }


    protected function publishUser($overrides = [])
    {
        $this->withExceptionHandling();

        $users = make('App\User', $overrides);

        return $this->post('/api/register', $users->toArray());
    }

}
