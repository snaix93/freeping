<?php

namespace App\Data\Casters;

use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Caster;

class DatetimeCaster implements Caster
{
    public function cast(mixed $value): mixed
    {
        return Carbon::create($value);
    }
}
