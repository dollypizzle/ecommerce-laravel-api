<?php

namespace App\Data\Repositories\Products;

use App\Products;
use Illuminate\Http\Request;

interface EloquentRepository
{

    public function index();

    public function store($input);

    public function show(Products $products);

    public function update($products, $input);

    public function destroy($products);

}

