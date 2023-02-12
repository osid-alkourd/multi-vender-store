<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'category_id', 'store_id',
        'price', 'compare_price', 'status',
    ]; 
    
    protected $hidden = [
        'image' , 
        'created_at' ,  'updated_at' , 'deleted_at'
    ];
    
    protected $appends = [
       'image_url' , 
    ];
    protected static function booted(){

        static::addGlobalScope('store' , new StoreScope());

    //  static::addGlobalScope('store' , function(Builder $builder){
    //     $user = Auth::user();
    //     if($user->store_id)
    //           $builder->where('store_id' , '=' , $user->store_id);     
    //   });
      static::creating(function(Product $product){
        $product->slug = Str::slug($product->name);
      });
    }
    
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }

    public function store(){
        return $this->belongsTo(Store::class , 'store_id' , 'id');
    }
    
    public function category(){
        return $this->belongsTo(Category::class , 'category_id' , 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // Related Model
            'product_tag',  // Pivot table name
            'product_id',   // FK in pivot table for the current model
            'tag_id',       // FK in pivot table for the related model
            'id',           // PK current model
            'id'            // PK related model
        );
    }

    // Accesser , will invoke like this $product->image_url
    public function getImageUrlAttribute(){
        if(!$this->image){
            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if(Str::startsWith($this->image ,['http://' , 'https://'])){
            return $this->image;
        }
        return asset('storage/'. $this->image);

    }

    public function getSalePercentAttribute(){
        if(!$this->compare_price){
           return 0;
        }
        return round(100 - ($this->price / $this->compare_price * 100));
    }

    public function scopeFilter(Builder $builder , $filters){
           $options = array_merge([
             'store_id' => null , 
             'category_id' => null , 
             'tag_id' => null  ,
             'status' => 'active' , 
           ], $filters);

        //    $builder->when($options['status'] , function($query , $status){
        //        $query->where('status' , $status);
        //    });

           $builder->when($options['store_id'] , function($builder , $store_id){
               $builder->where('store_id' , $store_id);
           });

           $builder->when($options['category_id'] , function($builder , $category_id){
               $builder->where('category_id' , $category_id);
           });

           $builder->when($options['tag_id'] , function($builder , $tag_id){
              $builder->whereExist(function($query) use($tag_id) {
                  $query->select(1)
                        ->from('product_tag')
                        ->whereRaw('product_id = products.id')
                        ->where('tag_id' , $tag_id);
              });
           });

    }
}
