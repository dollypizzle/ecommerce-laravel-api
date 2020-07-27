<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Products extends Model
{
    protected $guarded = [];

    protected $with = ['owner'];

    public function path()
    {
        return "/api/products/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

}
