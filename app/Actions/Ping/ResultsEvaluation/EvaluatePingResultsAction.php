<?php

namespace App\Actions\Ping\ResultsEvaluation;

use App\Models\Target;
use Illuminate\Support\Collection;

class EvaluatePingResultsAction
{
    private const UNRESOLVABLE          = 'unresolvable';
    private const ALL_ALIVE             = 'all-alive';
    private const ALL_UNREACHABLE       = 'all-unreachable';
    private const PARTIALLY_DOWN        = 'partially-down';
    private const PARTIALLY_UP          = 'partially-up';
    private const MIXED_PARTIAL_RESULTS = 'mixed-results';

    public function __invoke(Collection $connects)
    {
        Target::query()
            ->whereIn('connect', $connects)
            ->with('user', 'pingResults')
            ->lazyById()
            ->each(function (Target $target) {
                $this->evaluateResults($target);
            });
    }

    private function evaluateResults(Target $target)
    {
        $actionLookup = [
            self::UNRESOLVABLE          => PingUnresolvableAction::class,
            self::ALL_ALIVE             => PingAllAliveAction::class,
            self::ALL_UNREACHABLE       => PingAllUnreachableAction::class,
            self::PARTIALLY_DOWN        => PingPartiallyDownAction::class,
            self::PARTIALLY_UP          => PingPartiallyUpAction::class,
            self::MIXED_PARTIAL_RESULTS => PingMixedResultsAction::class,
        ];

        resolve($actionLookup[$this->determineAction($target)])($target);
    }

    private function determineAction(Target $target): string
    {
        return match (true) {
            $target->pingResults->containsUnresolvableTarget() => self::UNRESOLVABLE,
            $target->pingResults->allAlive() => self::ALL_ALIVE,
            $target->pingResults->allUnreachable() => self::ALL_UNREACHABLE,
            // At this point we have mixed results from the ping nodes...
            $target->isOnline(), $target->isAwaitingResults() => self::PARTIALLY_DOWN,
            $target->isUnreachable() => self::PARTIALLY_UP,
            default => self::MIXED_PARTIAL_RESULTS,
        };
    }
}
