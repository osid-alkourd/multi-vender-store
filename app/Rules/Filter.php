<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Filter implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

     protected $forbidden ;
    public function __construct($forbidden)
    {
        $this->forbidden = $forbidden;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       
         return ! in_array(strtolower($value) , $this->forbidden);
        // if(strtolower($value) == $this->forbidden)
        //             return false;
        //  return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    // this function will invoke if passes function return false 
    public function message()
    {
        return 'The name is forbidden ';
    }
}
