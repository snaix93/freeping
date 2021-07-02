<?php


namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;

class NotArrayRule implements Rule
{

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
       if(is_array($value)) {
           return false;
       }
       return true;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return "data type list or array is not allowed.";
    }
}
