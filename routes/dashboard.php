<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\DashboardController;



Route::group([
     'middleware' => ['auth'] ,
     'as' => 'dashboard.' ,
    'prefix' => 'dashboard' ,
    // 'namespace' => 'App\Http\Controller\Dashboard' ,
] ,function(){
    Route::get('/' , [DashboardController::class , 'index'])
        ->middleware(['auth'])
        ->name('dashboard');


     // Route::get('/categories/{category}', [CategoriesController::class, 'show'])
    //     ->name('categories.show')
    //     ->where('category', '\d+'); // this where function means to add condition on this route

    Route::get('/categories/trash', [CategoriesController::class, 'trash'])
        ->name('categories.trash');
    Route::put('categories/{category}/restore', [CategoriesController::class, 'restore'])
        ->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])
        ->name('categories.force-delete');
    Route::resource('/categories' , CategoriesController::class);
    // name for route resources for index will be dashboard.cetegories.index
    Route::resource('/products' , ProductsController::class);

});

