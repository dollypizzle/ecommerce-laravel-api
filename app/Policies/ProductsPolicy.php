<?php

namespace App\Policies;

use App\Products;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductsPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Products $product)
    {
        return $product->owner_id == $user->id;
    }
}
