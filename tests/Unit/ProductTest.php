<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_product_has_an_owner()
    {
        $product = factory('App\Products')->make();

        $this->assertInstanceOf('App\User', $product->owner);
    }


    /** @test */
    public function a_product_has_a_path()
    {
        $product = make('App\Products');

        $this->assertEquals("/api/products/{$product->id}", $product->path());
    }

}
