<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{
    use HasFactory;
    // intermediate table between order and product
    // in the pivot class it will assume that table name will be order_item insted of order_items
    protected $table = 'order_items';

    public $incrementing = true; // auto increment

    public $timestamps = false; // because we delete timestamp filed from migration file

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' => $this->product_name
        ]);
    }

    // order has many items
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
}
