<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;
use Validator;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::get();

        return response($products, 200);
    }

    public function store(Request $request)
    {

        request()->validate([
            'name' => 'required',
            'brand' => 'required',
            'image' => 'required',
            'price' => 'required',
            'description' => 'required'
        ]);

        $products = Products::create([
            'owner_id' => auth()->id(),
            'name' => request('name'),
            'brand' => request('brand'),
            'image' => request('image'),
            'price' => request('price'),
            'description' => request('description'),
        ]);

        $response = [
            'success' => true,
            'message' => 'Products stored successfully.',
            'data' => $products,
        ];

        return response()->json($response, 200);

    }

    public function show(Products $products, $id)
    {

        $products = Products::find($id);

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
        $products = Products::find($id);
        $products->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $products,
            "message" => "Product updated successfully"
        ], 200);
    }

    public function destroy($id)
    {
        $products = Products::findOrFail($id);
        $products->delete();

        return response()->json([
            'success' => true,
            "message" => "Product deleted"
        ], 200);
    }
}
