<?php

namespace App\Collections;

use App\Data\Target\TargetReportData;
use App\Support\Mail\MarkdownTableBuilder;
use Illuminate\Support\Collection;

class ReportDataCollection extends Collection
{
    public function formatStatsAsMarkdownTable(): MarkdownTableBuilder
    {
        $nodeNames = $this
            ->flatMap(fn(TargetReportData $data) => collect($data->stats)->pluck('nodeName')->all())
            ->unique()
            ->all();

        return resolve(MarkdownTableBuilder::class)
            ->headers('Host', ...$nodeNames)
            ->align(
                MarkdownTableBuilder::LEFT,
                ...array_fill(0, count($nodeNames), MarkdownTableBuilder::CENTER)
            )
            ->rows(...$this->map(fn(TargetReportData $reportData) => [
                $reportData->connect,
                ...collect($reportData->stats)->pluck('successRate')->all(),
            ]));
    }
}
