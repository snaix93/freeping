<?php

namespace App\Models\Collections;

use App\Models\PingResult;
use App\Support\Mail\MarkdownTableBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Collect;

class PingResultCollection extends Collection
{
    public function whereNodeId($nodeId): PingResultCollection
    {
        return $this->where('node_id', $nodeId);
    }

    public function allAlive(): bool
    {
        return $this
            ->filter(fn(PingResult $pingResult) => $pingResult->isUnreachable() || $pingResult->isUnresolvable())
            ->isEmpty();
    }

    public function allUnreachable(): bool
    {
        return $this
            ->filter(fn(PingResult $pingResult) => $pingResult->isAlive() || $pingResult->isUnresolvable())
            ->isEmpty();
    }

    public function containsUnresolvableTarget(): bool
    {
        return $this->onlyUnresolvable()->isNotEmpty();
    }

    public function onlyUnresolvable()
    {
        return $this->filter(fn(PingResult $pingResult) => $pingResult->isUnresolvable());
    }

    public function getNewUnreachable(Collect $nodesPreviouslyDown)
    {
        return $this->onlyUnreachable()->pluck('node_id')->diff($nodesPreviouslyDown);
    }

    public function onlyUnreachable()
    {
        return $this->filter(fn(PingResult $pingResult) => $pingResult->isUnreachable());
    }

    public function getNewAlive(Collect $nodesPreviouslyDown)
    {
        return $this->onlyAlive()->pluck('node_id')->intersect($nodesPreviouslyDown);
    }

    public function onlyAlive()
    {
        return $this->filter(fn(PingResult $pingResult) => $pingResult->isAlive());
    }

    public function formatResultsAsMarkdownTable(): MarkdownTableBuilder
    {
        return resolve(MarkdownTableBuilder::class)
            ->headers('Location', 'Ping Time', 'Status')
            ->align(
                MarkdownTableBuilder::LEFT,
                MarkdownTableBuilder::LEFT,
                MarkdownTableBuilder::RIGHT,
            )
            ->rows(...$this->map(fn(PingResult $pingResult) => [
                $pingResult->node->short_name,
                $pingResult->ping_time,
                $pingResult->status->description,
            ]));
    }
}
