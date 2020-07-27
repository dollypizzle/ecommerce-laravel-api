<?php

namespace App\Http\Controllers;

use App\Data\Repositories\Products\ProductsRepository;
use App\Products;

class ProductsController extends Controller
{
    protected $products_repository;

    public function __construct(ProductsRepository $products_repository)
    {
        $this->products_repository = $products_repository;
    }

    public function index()
    {
        $products = $this->products_repository->index();

        return response()->json([
            'products' => $products,
        ], 200);
    }

    public function store()
    {
        $input = request()->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'description' => 'required|string'
        ]);

        $input['owner_id'] = auth()->id();

        $product = $this->products_repository->store($input);

        $response = [
            'success' => true,
            'data' => $product,
            'message' => 'Product created successfully.',
        ];

        return response()->json($response, 200);
    }

    public function show(Products $products)
    {
        return response()->json([
            'product' => $products,
        ], 200);
    }

    public function update(Products $products)
    {
        $this->authorize('update', $products);

        $input = request()->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string',
            'description' => 'required|string'
        ]);

        $this->products_repository->update($products, $input);

        return response()->json([
            'success' => true,
            'product' => $products,
            "message" => "Product updated successfully"
        ], 200);

    }

    public function destroy(Products $products)
    {
        $products = $this->products_repository->destroy($products);

        return response()->json([
            'success' => true,
            'product' => $products,
            "message" => "Product deleted successfully"
        ], 200);
    }
}
