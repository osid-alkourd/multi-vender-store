<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;

Route::group([
     'middleware' => ['auth' ,'auth.type:admin,super-admin'] ,
     'as' => 'dashboard.' ,
     'prefix' => 'dashboard' ,
    // 'namespace' => 'App\Http\Controller\Dashboard' ,
] ,function(){
    Route::get('/' , [DashboardController::class , 'index'])
        ->name('dashboard');
 
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');     

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

