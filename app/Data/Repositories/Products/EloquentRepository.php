<?php

namespace App\Data\Repositories\Products;

use Illuminate\Http\Request;

interface EloquentRepository
{
    public function all();

    public function create();

    public function show($id);

    public function update(Request $request, $id);

    public function delete($id);

}
