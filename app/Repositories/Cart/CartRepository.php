<?php 
namespace App\Repositories\Cart;

use App\Models\Product;
use Illuminate\Support\Collection;

// the goal of repository is to controle the storage ways , I need to store in session or I need to Store in DB
// and so
interface CartRepository {

    public function get() : Collection ;

    public function add(Product $product, $quantity = 1);

    public function update(Product $product, $quantity);
 
    public function delete($id);

    public function empty();

    public function total() : float;

}