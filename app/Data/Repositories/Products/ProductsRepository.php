<?php

namespace App\Data\Repositories\Products;

use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsRepository implements EloquentRepository
{

    protected $products;

    public function __construct(Products $products)
    {
        $this->products = $products;
    }


    public function index()
    {
        return $this->products->all();
    }

    public function store($input)
    {
        return $this->products->create($input);
    }

    public function show(Products $products)
    {
        return $products->get($products);
    }

    public function update($products, $input)
    {
        return $products->update($input);
    }

    public function destroy($products)
    {
        return $products->delete();
    }
}

