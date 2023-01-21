<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\CartObserver;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
class Cart extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = [
        'cookie_id', 'user_id', 'product_id', 'quantity', 'options',
    ];
    
    // Events (Observers)
    // creating, created, updating, updated, saving, saved
    // deleting, deleted, restoring, restored, retrieved

    protected static function booted()
    {
        static::observe(CartObserver::class);

     
        // static::creating(function(Cart $cart) {
        //     $cart->id = Str::uuid();
        // });
    }

   
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous',
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
