<?php

namespace App\Providers;

use App\Data\Repositories\Products\EloquentRepository as ProductsEloquent;
use App\Data\Repositories\Products\ProductsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */

    // public function register()
    // {
    //     $this->app->bind(ProductsRepository::class, ProductsEloquent::class );
    // }

    public function register()
    {
        $this->app->bind(
            'App\Data\Repositories\Products\EloquentRepository',
            'App\Data\Repositories\Products\ProductsRepository');
        $this->app->bind(
            'App\Data\Repositories\Users\EloquentRepository',
            'App\Data\Repositories\Users\UsersRepository');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
