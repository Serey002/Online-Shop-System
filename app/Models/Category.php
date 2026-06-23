<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{ 

    protected $fillable = [
        'name',
        'slug'
    ];

    //Get all  product belong to this category
    public function products() {
        return $this->hasMany(Product::class);
    }
}
