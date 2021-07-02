<?php

namespace App\Data\WebCheck\Casters;

use Spatie\DataTransferObject\Caster;

class WebCheckHeadersCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        if (blank($value)) {
            return null;
        }

        return collect($value)
            ->reject(fn($item) => blank($item['key']) || blank($item['value']))
            ->all();
    }
}
