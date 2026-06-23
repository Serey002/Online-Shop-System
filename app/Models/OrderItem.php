<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    //Get the order record
    public function order() {
        return $this->belongsTo(Order::class);
    }

    //Get the product item purchased in this row
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
