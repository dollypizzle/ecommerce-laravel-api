<?php

namespace App\Data\Controllers;

use App\Data\Repositories\Products\ProductsRepository;
use App\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $products_repository;

    public function __construct(ProductsRepository $products_repository)
    {
        $this->products_repository = $products_repository;
    }

    public function index()
    {
        $products = $this->products_repository->all();

        return response($products, 200);
    }

    public function create()
    {
        $products = $this->products_repository->create();

        $response = [
            'success' => true,
            'message' => 'Products stored successfully.',
            'data' => $products,
        ];

        return response()->json($response, 200);
    }

    public function show(Products $products, $id)

    {
        $products = $this->products_repository->show($id);

        if (is_null($products)) {
            $response = [
                'success' => false,
                'data' => 'Empty',
                'message' => 'Products not found.'
            ];
            return response()->json($response, 404);
        }

        $response = [
            'success' => true,
            'data' => $products,
            'message' => 'Products retrieved successfully.'
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $products = $this->products_repository->update($request, $id);
        $products->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $products,
            "message" => "Product updated successfully"
        ], 200);
    }

    public function destroy($id)
    {
        $this->products_repository->delete($id);

        return response()->json([
            'success' => true,
            "message" => "Product deleted"
        ], 200);
    }
}
