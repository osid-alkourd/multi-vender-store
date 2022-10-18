<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\CategoriesController;
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

    Route::resource('/categories' , CategoriesController::class);
    // name for route resources for index will be dashboard.cetegories.index
});

