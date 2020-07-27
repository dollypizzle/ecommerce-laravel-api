<?php

namespace Tests\Feature;

use App\Productss;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    function test_a_user_can_create_a_product()
    {
        $header = $this->signIn();

        $credentials = [
            'name' => 'Sony vio',
            'brand' => 'Sony',
            'image' => 'http//unsplash.com/helloworld',
            'price' => '2000',
            'description' => 'A phone you will love'
        ];

        $this->json('POST', '/api/products', $credentials, $header)
            ->assertStatus(200);
        $this->assertDatabaseHas('products', $credentials);
    }

    /** @test */
    function test_a_guest_cannot_create_a_product()
    {
        $header = $this->withExceptionHandling()->signIn();

        $this->post('/api/products', $header)
            ->assertRedirect('/api/login')
            ->assertStatus(302);
    }

    /** @test */
    function test_a_user_can_view_all_products()
    {
        $product1 = factory('App\Products')->create([
            'name' => 'Sony vio',
            'brand' => 'Sony',
            'image' => 'http//unsplash.com/helloworld',
            'price' => '2000',
            'description' => 'A phone you will love'
        ]);

        $product2 = factory('App\Products')->create([
            'name' => 'Sony vio',
            'brand' => 'Sony',
            'image' => 'http//unsplash.com/helloworld',
            'price' => '2000',
            'description' => 'A phone you will love'
        ]);

        $response = $this->json('GET', '/api/products', [])
            ->assertStatus(200)
            ->assertSee($product1->name, $product2->name);
    }


    /** @test */
    function test_a_product_requires_a_name()
    {
        $this->publishProduct(['name' => ''])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    function test_a_product_requires_a_brand()
    {
        $this->publishProduct(['brand' => ''])
            ->assertSessionHasErrors('brand');
    }

    /** @test */
    function test_a_product_requires_a_image()
    {
        $this->publishProduct(['image' => ''])
            ->assertSessionHasErrors('image');
    }

    /** @test */
    function test_a_product_requires_a_price()
    {
        $this->publishProduct(['price' => ''])
            ->assertSessionHasErrors('price');
    }

    /** @test */
    function test_a_product_requires_a_description()
    {
        $this->publishProduct(['description' => ''])
            ->assertSessionHasErrors('description');
    }

    /** @test */
    function test_a_product_cannot_be_updated_by_a_guest()
    {
        $this->withExceptionHandling();

        $header = $this->signIn();

        $product = create('App\Products',
            ['owner_id' => create('App\User')->id]
        );

        $this->patch($product->path(), [], $header)
            ->assertStatus(403);
    }

    /** @test */
    function test_a_product_can_only_be_updated_by_its_owner()
    {
        $this->withExceptionHandling();
        $user = create('App\User');

        $token = $user->createAccessToken($user);
        $headers = ['Authorization' => "Bearer $token"];

        $product = create('App\Products',
            ['owner_id' => $user->id]
        );

        $input = [
            'name' => 'Sony vio',
            'brand' => 'Sony',
            'image' => 'http//unsplash.com/helloworld',
            'price' => '2000',
            'description' => 'A phone you will love'
        ];

        $this->json('PATCH', $product->path(), $input, $headers)
            ->assertStatus(403);
    }

    function test_a_product_can_only_be_deleted_by_owner()
    {
        $header = $this->signIn();

        $product = factory('App\Products')->create([
            'name' => 'Sony vio',
            'brand' => 'Sony',
            'image' => 'http//unsplash.com/helloworld',
            'price' => '2000',
            'description' => 'A phone you will love'
        ]);

        $this->json('DELETE', $product->path(), [], $header)
            ->assertStatus(200);
    }

    protected function publishProduct($overrides = [])
    {
        $header =  $this->withExceptionHandling()->signIn();

        $products = make('App\Products', $overrides);

        return $this->post('/api/products', $products->toArray(), $header);
    }

    protected function createAccessToken ($user) {
        return $user->createToken('App Access Token')->accessToken;
    }
}
