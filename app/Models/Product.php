<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'stock'
    ];

    //Get the category that own the product
    public function category(){
        return $this->belongsTo(Category::class);
    }

    // Get order items associated with this product
    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }

    //Get all reviews left for this product
    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
