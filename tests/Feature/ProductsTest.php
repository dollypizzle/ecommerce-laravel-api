<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->product = create('App\Products');
    }

    /** @test */
    public function a_user_can_view_all_products()
    {
        $response = $this->get('/products')
                ->assertSee($this->product->title);
    }

    /** @test */
    function a_user_can_read_a_single_product()
    {
        $this->get($this->product->path())
            ->assertSee($this->product->title);
    }

}
