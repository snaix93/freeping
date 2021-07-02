<?php

namespace App\Actions;

use App\Data\LocationData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetUserTimezoneData
{
    public function __invoke(): LocationData
    {
        return collect(Cache::remember("geoip-lookup:".$ip = request()->ip(), now()->addWeek(),
            fn() => Http::get(
                "https://api.ipapi.com/api/{$ip}?access_key=f66f6d04f3636affb6c6fc3729ed361b"
            )->json()
        ))->pipe(fn(Collection $ipData) => new LocationData(
            timezone: $timezone = data_get($ipData, 'time_zone.id') ?? "Europe/London",
            countryCode: data_get($ipData, 'country_code') ?? "GB",
            currentTime: now($timezone),
            data: $ipData->toArray(),
        ));
    }
}
