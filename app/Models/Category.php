<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;



class Category extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name' , 'parent_id' , 'description' , 'image' , 'status' , 'slug' ,
    ];


  public function products(){
    return $this->hasMany(Product::class , 'category_id' , 'id');
  }

    public function scopeActive(Builder $builder){
       $builder->where('status' , '=' , 'active');
    }


    public function scopeFilter(Builder $builder , $filters){

         $builder->when($filters['name'] ?? false , function($builder , $value){
           $builder->where('categories.name','LIKE',"%{$value}%");
         });

         $builder->when($filters['status'] ?? false , function($builder , $value){
            $builder->where('categories.status' , $value);               
         });

         /*
        if($filters['name'] ?? false)
             $builder->where('categories.name','LIKE',"%{$filters['name']}%");

       if($filters['status'] ?? false)
             $builder->whereStatus($filters['status']); 
        */              
    }

   public function parent()
   {
       return $this->belongsTo(Category::class , 'parent_id' , 'id')->withDefault([
        'name' => '-'
       ]);
   }

   public function children()
   {
      return $this->hasMany(Category::class , 'parent_id' , 'id');
   }

    public static function rules($id = null){
          return [
            'name' => ['required' , 'string' , 'min:3' , 'max:255' ,
                        Rule::unique('categories' , 'name')->ignore($id) ,
                        /*
                        // custom validation rule
                        function($attribute , $value , $fail){
                           if(strtolower($value) == 'laravel')
                                $fail("The $attribute is forbidden");
                        } , 
                        */
                        //new Filter(['laravel' , 'php' , 'html' , 'css' , 'js']) , 
                        'filter:php,laravel,html,css,js'
              ] , 
            'parent_id' => ['nullable' , 'int' ,'exists:categories,id'] , 
            'image' => ['image' , 'max:1048576' , 'dimensions:min_width:100,min_height:100'] ,
            'status' => [ 'required' , Rule::in(['active' , 'archived'])] ,    

          ];
    }
}
