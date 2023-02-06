<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class , 'index'])->name('home');

Route::get('/products', [ProductsController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product:slug}', [ProductsController::class, 'show']) // will use the slug insted of id
    ->name('products.show');

Route::resource('cart', CartController::class);

Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('checkout', [CheckoutController::class, 'store']);

Route::get('auth/user/2fa' , [TwoFactorAuthenticationController::class , 'index'])
   ->middleware('auth')
   ->name('front.2fa');

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/



//require __DIR__.'/auth.php';  // comment this because i will using Fortify insted of breeze
require __DIR__.'/dashboard.php';
