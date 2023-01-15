<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name', 'slug'
    ];

    public function products()
    {
        return $this->belongsToMany(
            Product::class ,
            'product_tag' , // pivot table
            'tag_id' , // FK in the pivot table for the current model
            'product_id' , // FK in the pivot table for related model
            'id', // PK for the current model 
            'id', // PK for related model  
        );
    }
}
