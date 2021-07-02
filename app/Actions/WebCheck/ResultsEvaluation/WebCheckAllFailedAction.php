<?php

namespace App\Actions\WebCheck\ResultsEvaluation;

use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Problem;
use App\Models\WebCheck;

class WebCheckAllFailedAction
{
    public function __invoke(WebCheck $webCheck)
    {
        if ($webCheck->isFailed()) {
            return;
        }

        $monitoringEvent = MonitoringEventData::create(EventOriginator::WebCheck(), [
            'connect'         => $webCheck->url_host,
            'type'            => 'Web check failed',
            'description'     => "{$webCheck->url_host} failing at all locations",
            'meta'            => $webCheck->webCheckResults->mapToMetaForProcessing(),
            'checkDefinition' => $webCheck->getCheckDefinition(),
        ]);

        $webCheck->last_alert_at = now();
        $webCheck->number_of_alerts++;

        Problem::dispatch($webCheck->user, $monitoringEvent);

        $webCheck->markAsFailed()->save();
    }
}
