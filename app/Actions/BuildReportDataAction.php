<?php

namespace App\Actions;

use App\Collections\ReportDataCollection;
use App\Data\Target\TargetReportData;
use App\Data\Target\TargetReportStats;
use App\Models\Node;
use App\Models\PingStats;
use App\Models\Target;
use App\Models\User;

class BuildReportDataAction
{
    public function __invoke(User $user): ReportDataCollection
    {
        $nodes = Node::select('short_name')->orderBy('name')->get();

        $user->load(['targets' => function ($query) use ($nodes) {
            $pingStatsSubQuery = PingStats::query()
                ->select('connect', 'nodes.short_name as node_name')
                ->selectRaw('SUM(`successes`) AS successes')
                ->selectRaw('SUM(`successes` + `failures` + `errors`) AS total_checks')
                ->join('nodes', 'ping_stats.node_id', '=', 'nodes.id')
                ->whereDate('datestamp', now()->subDay())
                ->groupBy('connect', 'node_name');

            $query
                ->select('targets.id', 'targets.user_id', 'targets.connect')
                ->tap(function ($query) use ($nodes) {
                    $nodes->each(function (Node $node) use ($query) {
                        return $query->selectRaw(
                            "MAX(CASE WHEN node_name = '{$node->short_name}' THEN (successes/total_checks) ELSE NULL END) AS '{$node->short_name}'"
                        );
                    });
                })
                ->joinSub($pingStatsSubQuery, 'sub', 'targets.connect', '=', 'sub.connect')
                ->groupBy('id', 'targets.connect', 'targets.user_id');
        }]);

        return ReportDataCollection::make(
            $user->targets->map(fn(Target $target) => new TargetReportData(
                $target->connect,
                ...collect($target->toArray())
                ->except('id', 'user_id', 'connect')
                ->map(fn($successRate, $nodeName) => new TargetReportStats(
                    successRate: round($successRate * 100, 2).'%',
                    nodeName: $nodeName
                ))
                ->values()
                ->all(),
            ))
        );
    }
}
