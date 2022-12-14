<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected static function booted(){

        static::addGlobalScope('store' , new StoreScope());


    //  static::addGlobalScope('store' , function(Builder $builder){
    //     $user = Auth::user();
    //     if($user->store_id)
    //           $builder->where('store_id' , '=' , $user->store_id);     
    //   });
    }


    public function store(){
        return $this->belongsTo(Store::class , 'store_id' , 'id');
    }
    
    public function category(){
        return $this->belongsTo(Category::class , 'category_id' , 'id');
    }
}
