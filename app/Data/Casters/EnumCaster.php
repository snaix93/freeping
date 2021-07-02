<?php

namespace App\Data\Casters;

use Exception;
use ReflectionClass;
use Spatie\DataTransferObject\Caster;

class EnumCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        $enumClass = (new ReflectionClass(data_get($trace = debug_backtrace(), '2.object')))
            ->getProperty(data_get($trace, '1.object.name'))
            ->getType()
            ->getName();

        return $enumClass::coerce($value)
            ?? throw new Exception(
                "Wrong value passed for enum coercion for {$enumClass} with value '{$value}'"
            );
    }
}
