<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_have_many_products()
    {
        $user = factory('App\User')->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->products);
    }
}
