<?php


namespace App\Rules;


class NotListRule implements \Illuminate\Contracts\Validation\Rule
{

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        return array_values($value)!==$value;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return "Data type list is not allowed. Use array.";
    }
}
