<?php

namespace App\Actions;

class GetTimeZoneData
{
    public function __invoke($timezone)
    {
        return (resolve(BuildTimezones::class)())->first(
            fn($item) => $item['value'] === $timezone
        );
    }
}
