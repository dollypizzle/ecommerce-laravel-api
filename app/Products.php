<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Products extends Model
{
    protected $table = 'products';

    protected $with = ['owner'];

    protected $fillable = [
        'owner_id',
        'name',
        'brand',
        'price',
        'image',
        'description'
    ];

    protected $guarded = [];

    public function path()
    {
        return "/products/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    protected static function booted()
    {
        static::creating(function ($products) {
            $products->owner_id = Auth::id();
        });
    }
}
