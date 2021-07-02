<?php

namespace App\Models\Collections;

use App\Models\Port;
use App\Models\ScanResult;
use App\Support\Mail\MarkdownTableBuilder;
use App\Support\PortService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Collect;

class ScanResultCollection extends Collection
{
    public function whereNodeId($nodeId): ScanResultCollection
    {
        return $this->where('node_id', $nodeId);
    }

    public function allOpen(): bool
    {
        return $this
            ->filter(fn(ScanResult $scanResult) => $scanResult->isClosed())
            ->isEmpty();
    }

    public function allClosed(): bool
    {
        return $this
            ->filter(fn(ScanResult $scanResult) => $scanResult->isOpen())
            ->isEmpty();
    }

    public function getNewClosed(Collect $nodesPreviouslyClosed)
    {
        return $this->onlyClosed()->pluck('node_id')->diff($nodesPreviouslyClosed);
    }

    public function onlyClosed()
    {
        return $this->filter(fn(ScanResult $scanResult) => $scanResult->isClosed());
    }

    public function getNewOpen(Collect $nodesPreviouslyDown)
    {
        return $this->onlyOpen()->pluck('node_id')->intersect($nodesPreviouslyDown);
    }

    public function onlyOpen()
    {
        return $this->filter(fn(ScanResult $scanResult) => $scanResult->isOpen());
    }

    public function formatResultsAsMarkdownTable(
        Port $port,
        ?MarkdownTableBuilder $builder = null
    ): MarkdownTableBuilder {

        $items = $this->sortBy('node.short_name');

        if (is_null($builder)) {
            $nodeNames = $items
                ->flatMap(fn(ScanResult $result) => $result->node->pluck('short_name')->all())
                ->unique()
                ->sort()
                ->all();

            $builder = resolve(MarkdownTableBuilder::class)
                ->headers('Port', ...$nodeNames)
                ->align(
                    MarkdownTableBuilder::LEFT,
                    ...array_fill(0, count($nodeNames), MarkdownTableBuilder::CENTER)
                );
        }

        return $builder
            ->row([
                PortService::forPort($port->port),
                ...$items
                    ->map(fn(ScanResult $scanResult) => $scanResult->status->description)
                    ->all(),
            ]);
    }
}
