<?php

namespace App\Actions\WebCheck\ResultsEvaluation;

use App\Models\WebCheck;
use Illuminate\Support\Collection;

class EvaluateWebCheckResultsAction
{
    private const ALL_SUCCESSFUL        = 'all-successful';
    private const ALL_FAILED            = 'all-failed';
    private const PARTIALLY_FAILED      = 'partially-failed';
    private const PARTIALLY_SUCCESSFUL  = 'partially-successful';
    private const MIXED_PARTIAL_RESULTS = 'mixed-results';

    public function __invoke(Collection $uuids)
    {
        WebCheck::query()
            ->whereIn('uuid', $uuids)
            ->with('user', 'webCheckResults')
            ->lazyById()
            ->each(function (WebCheck $webCheck) {
                $this->evaluateResults($webCheck);
            });
    }

    private function evaluateResults(WebCheck $webCheck)
    {
        $actionLookup = [
            self::ALL_SUCCESSFUL        => WebCheckAllSuccessfulAction::class,
            self::ALL_FAILED            => WebCheckAllFailedAction::class,
            // At this we have mixed results from the ping nodes...
            self::PARTIALLY_FAILED      => WebCheckPartiallyFailedAction::class,
            self::PARTIALLY_SUCCESSFUL  => WebCheckPartiallySuccessfulAction::class,
            self::MIXED_PARTIAL_RESULTS => WebCheckMixedResultsAction::class,
        ];

        resolve($actionLookup[$this->determineAction($webCheck)])($webCheck);
    }

    private function determineAction(WebCheck $webCheck): string
    {
        return match (true) {
            $webCheck->webCheckResults->allSuccessful() => self::ALL_SUCCESSFUL,
            $webCheck->webCheckResults->allFailed() => self::ALL_FAILED,
            // At this we have mixed results from the ping nodes...
            $webCheck->isSuccessful(), $webCheck->isAwaitingResults() => self::PARTIALLY_FAILED,
            $webCheck->isFailed() => self::PARTIALLY_SUCCESSFUL,
            default => self::MIXED_PARTIAL_RESULTS,
        };
    }
}
