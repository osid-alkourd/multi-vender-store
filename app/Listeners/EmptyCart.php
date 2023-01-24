<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\Cart;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cookie;



class EmptyCart
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event )
    {
      //  $cart->empty();
      $cookie_id = Cookie::get('cart_id');
      Cart::where('cookie_id' ,'=' , $cookie_id)->delete();

    }
}
