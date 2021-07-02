<?php

namespace App\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BuildTimezones
{
    public function __invoke(): Collection
    {
        return Cache::remember('timezones', now()->addWeek(), function () {
            return collect(timezone_identifiers_list())->map(function ($timezone) {
                date_default_timezone_set($timezone);

                return [
                    'value'  => $timezone,
                    'offset' => date('P', time()),
                ];
            })->sortBy('offset')->values();
        });
    }
}
