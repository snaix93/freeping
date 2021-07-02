<?php /** @noinspection PhpParamsInspection */

namespace App\Actions;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class BuildTimePeriods
{
    public function __invoke(): Collection
    {
        return Cache::remember('time-periods', now()->addMonth(), function () {
            return collect(CarbonInterval::minutes('60')->toPeriod('00:00', '23:00'))
                ->map(fn(Carbon $date) => [
                    'value' => $date->format('H:i'),
                    'text'  => $date->format('g:i A'),
                ]);
        });
    }
}
