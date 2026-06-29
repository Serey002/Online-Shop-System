<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'user_id',
        'total_price',
        'total_amount',
        'items_summary',
        'notes',
        'status'
    ];

    //Get the user who place this order
    public function user() {
        return $this->belongsTo(User::class);
    }

    //Get the item break down for this order
    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
