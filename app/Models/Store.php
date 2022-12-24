<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    const CREATED_AT = 'created_at' ;
    const UPDATED_AT = 'updated_at' ;
    protected $connection  = 'mysql';
    protected $table = 'stores' ;
    protected $primaryKey = 'id' ;
    public $incrementing = true; // autoincrement
    public $timestamps = true; //  true: created_at and updated_at field are exist

    public function products(){
        return $this->hasMany(Product::class , 'store_id' , 'id');
    }
}
