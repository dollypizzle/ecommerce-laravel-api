<?php

namespace App\Data\Repositories\Products;

use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsRepository implements EloquentRepository
{

    public function all()
    {
        $products = Products::all();

        return $products;
    }

    public function create()
    {
        // $inputs = $request->all();
        // return Products::create($inputs);

        request()->validate([
            'name' => 'required|string',
            'brand' => 'required|string',
            'image' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        $products = Products::create([
            'owner_id' => Auth::id(),
            'name' => request('name'),
            'brand' => request('brand'),
            'image' => request('image'),
            'price' => request('price'),
            'description' => request('description'),
        ]);

        return $products;
    }

    public function show($id)
    {
        return Products::find($id);
    }

    public function update(Request $request, $id)
    {
        return Products::find($id);
    }

    public function delete($id)
    {
        return Products::findOrFail($id)->destroy($id);
    }
}

