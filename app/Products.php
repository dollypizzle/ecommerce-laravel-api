<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Products extends Model
{
    protected $table = 'products';

    protected $with = ['owner'];

    protected $guarded = [];

    public function path()
    {
        return "api/product/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // protected static function booted()
    // {
    //     static::creating(function ($products) {
    //         $products->owner_id = Auth::id();
    //     });

    //     static::updating(function ($products) {
    //         $products->owner_id = Auth::id();
    //     });
    // }
}
