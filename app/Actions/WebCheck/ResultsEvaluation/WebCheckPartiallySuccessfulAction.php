<?php

namespace App\Actions\WebCheck\ResultsEvaluation;

use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Problem;
use App\Models\WebCheck;

class WebCheckPartiallySuccessfulAction
{
    public function __invoke(WebCheck $webCheck)
    {
        $webCheck->last_warning_at = now();
        $webCheck->number_of_warnings++;

        $monitoringEvent = MonitoringEventData::create(EventOriginator::WebCheck(), [
            'connect'         => $webCheck->url_host,
            'type'            => 'Web check partially recovered',
            'severity'        => 'Warning',
            'description'     => "{$webCheck->url_host} partially recovered but failing at {$webCheck->webCheckResults->onlyFailed()->count()} of our check locations",
            'meta'            => $webCheck->webCheckResults->mapToMetaForProcessing(),
            'checkDefinition' => $webCheck->getCheckDefinition(),
        ]);

        $webCheck
            ->markAsPartiallyFailed()
            ->withNodesDown($webCheck->webCheckResults->onlyFailed()->pluck('node_id'))
            ->save();

        Problem::dispatch($webCheck->user, $monitoringEvent);
    }
}
