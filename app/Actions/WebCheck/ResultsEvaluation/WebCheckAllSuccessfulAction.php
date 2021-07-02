<?php

namespace App\Actions\WebCheck\ResultsEvaluation;

use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Recovery;
use App\Models\WebCheck;

class WebCheckAllSuccessfulAction
{
    public function __invoke(WebCheck $webCheck)
    {
        if ($webCheck->isSuccessful()) {
            return;
        }

        if (! $webCheck->isAwaitingResults()) {

            $monitoringEvent = MonitoringEventData::create(EventOriginator::WebCheck(), [
                'connect'         => $webCheck->url_host,
                'type'            => 'Web check ok',
                'description'     => "{$webCheck->url_host} down",
                'meta'            => $webCheck->webCheckResults->mapToMetaForProcessing(),
                'checkDefinition' => $webCheck->getCheckDefinition(),
            ]);

            $webCheck->last_recovery_at = now();
            $webCheck->number_of_recoveries++;

            Recovery::dispatch($webCheck->user, $monitoringEvent);
        }

        $webCheck->markAsSuccessful()->save();
    }
}
