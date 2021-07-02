<?php

namespace App\Data;

use Illuminate\Support\Carbon;

class LocationData
{
    public function __construct(
        public string $timezone,
        public string $countryCode,
        public Carbon $currentTime,
        public array $data
    ) {}
}
