<?php

namespace App\Actions\WebCheck\ResultsEvaluation;

use App\Data\Events\MonitoringEventData;
use App\Enums\EventOriginator;
use App\Events\Monitoring\Problem;
use App\Models\WebCheck;
use Illuminate\Support\Collection;

class WebCheckMixedResultsAction
{
    public function __invoke(WebCheck $webCheck)
    {
        /** @var Collection $nodesPreviouslyDownForWebCheck */
        $nodesPreviouslyDownForWebCheck = $webCheck->nodes_down;

        $webCheck->last_warning_at = now();
        $webCheck->number_of_warnings++;

        $webCheck
            ->markAsPartiallyFailed()
            ->withNodesDown($webCheck->webCheckResults->onlyFailed()->pluck('node_id'))
            ->save();

        $newSuccessful = $webCheck->webCheckResults
            ->getNewSuccessful($nodesPreviouslyDownForWebCheck);
        $newFailed = $webCheck->webCheckResults->getNewFailed($nodesPreviouslyDownForWebCheck);

        if ($newSuccessful->merge($newFailed)->isNotEmpty()) {

            $failedCount = $webCheck->webCheckResults->onlyFailed()->count();

            $monitoringEvent = MonitoringEventData::create(EventOriginator::WebCheck(), [
                'connect'         => $webCheck->url_host,
                'type'            => 'Web check partially failing',
                'description'     => "{$webCheck->url_host} is offline in {$failedCount} of our check locations",
                'severity'        => 'Warning',
                'meta'            => $webCheck->webCheckResults->mapToMetaForProcessing(),
                'checkDefinition' => $webCheck->getCheckDefinition(),
            ]);

            Problem::dispatch($webCheck->user, $monitoringEvent);
        }
    }
}
