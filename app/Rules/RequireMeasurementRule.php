<?php


namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;

class RequireMeasurementRule implements Rule
{
    public function __construct(private array $input)
    {

    }
    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        return count($this->input)!== 0;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return "You must send at least one measurement.";
    }
}
