<?php

namespace Tests\Feature;

use App\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_products()
    {
        $product = factory('App\Products')->create([
            'name' => 'Lorem',
            'brand' => 'Ipsum',
            'image' => 'Ipsum',
            'description' => 'Ipsum',
            'price' => '344',
        ]);

        $this->get('/api/products')
                ->assertSee($product->name);
    }

    /** @test */
    function a_guest_can_view_multiple_products()
    {
        $product = factory('App\Products')->create([
            'name' => 'Lorem',
            'brand' => 'Ipsum',
            'image' => 'Ipsum',
            'description' => 'Ipsum',
            'price' => '344',
        ]);

        $product2 = factory('App\Products')->create([
            'name' => 'Lorem2',
            'brand' => 'Ipsum2',
            'image' => 'Ipsum3',
            'description' => 'Ipsum3',
            'price' => '344',
        ]);

        $response = $this->json('GET', '/api/products', [])
            ->assertStatus(200)
            ->assertSee($product->name, $product2->name);
    }


    /** @test */
    function a_user_can_read_a_single_product()
    {
        $product = factory('App\Products')->create([
            'name' => 'Lorem',
            'brand' => 'Ipsum',
            'image' => 'Ipsum',
            'description' => 'Ipsum',
            'price' => '344',
        ]);

        $this->get($product->path())
            ->assertSee($product->name)
            ->assertSee($product->brand);
    }

    /** @test */
    function a_product_requires_a_name()
    {
        $this->publishProduct(['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    function a_product_requires_an_image()
    {
        $this->publishProduct(['image' => null])
            ->assertSessionHasErrors('image');
    }

    /** @test */
    function a_product_requires_a_description()
    {
        $this->publishProduct(['description' => null])
            ->assertSessionHasErrors('description');
    }

    /** @test */
    function a_product_requires_a_price()
    {
        $this->publishProduct(['price' => null])
            ->assertSessionHasErrors('price');
    }

    /** @test */
    function a_product_requires_a_brand()
    {
        $this->publishProduct(['brand' => null])
            ->assertSessionHasErrors('brand');
    }

    /** @test */
    function a_user_can_create_a_product()
    {
        $headers = $this->signIn();
        $input = [
            'name' => 'Lorem',
            'brand' => 'Ipsum',
            'image' => 'Ipsum',
            'description' => 'Ipsum',
            'price' => '344',
        ];

        $this->json('POST', '/api/products', $input, $headers)
            ->assertStatus(200);
    }

    /** @test */
    function a_guest_cannot_create_a_product()
    {
        $header = $this->withExceptionHandling()->signIn();

        $this->post('/api/products', $header)
            ->assertRedirect('/api/login')
            ->assertStatus(302);
    }

    /** @test */
    function a_product_can_be_updated()
    {
        $headers = $this->signIn();
        $product = factory('App\Products')->create([
            'name' => 'Lorem',
            'brand' => 'Ipsum',
            'image' => 'Ipsum',
            'description' => 'Ipsum',
            'price' => '344',
        ]);

        $input = [
            'name' => 'Lorem edit',
            'brand' => 'Ipsum edit',
        ];

        $response = $this->json('PATCH', '/api/product/' . $product->id, $input, $headers)
            ->assertStatus(200);
    }

    /** @test */
    function a_guest_cannot_edit_a_product()
    {
        $header = $this->withExceptionHandling()->signIn();

        $this->patch('/api/product/1', $header)
            ->assertRedirect('/api/login')
            ->assertStatus(302);
    }

    /** @test */
    function an_authenticated_user_delete_a_product()
    {
        $headers = $this->signIn();
        $product = factory('App\Products')->create([
            'name' => 'Lorem',
            'brand' => 'Ipsum',
            'image' => 'Ipsum',
            'description' => 'Ipsum',
            'price' => '344',
        ]);

        $this->json('DELETE', '/api/product/' . $product->id, [], $headers)
            ->assertStatus(200);
    }

    /** @test */
    function a_guest_cannot_delete_a_product()
    {
        $header = $this->withExceptionHandling()->signIn();

        $this->delete('/api/product/1', $header)
            ->assertRedirect('/api/login')
            ->assertStatus(302);
    }

    protected function publishProduct($overrides = [])
    {
        $header =  $this->withExceptionHandling()->signIn();

        $products = make('App\Products', $overrides);

        return $this->post('/api/products', $products->toArray(), $header);
    }
}
