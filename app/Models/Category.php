<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' , 'parent_id' , 'description' , 'image' , 'status' , 'slug' ,
    ];

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
