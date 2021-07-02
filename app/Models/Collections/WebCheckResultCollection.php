<?php

namespace App\Models\Collections;

use App\Models\WebCheckResult;
use App\Support\Mail\MarkdownTableBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Collect;

class WebCheckResultCollection extends Collection
{
    public function whereNodeId($nodeId): WebCheckResultCollection
    {
        return $this->where('node_id', $nodeId);
    }

    public function allSuccessful(): bool
    {
        return $this
            ->filter(fn(WebCheckResult $webCheckResult) => $webCheckResult->isFailed())
            ->isEmpty();
    }

    public function allFailed(): bool
    {
        return $this
            ->filter(fn(WebCheckResult $webCheckResult) => $webCheckResult->isSuccessful())
            ->isEmpty();
    }

    public function getNewFailed(Collect $nodesPreviouslyDown)
    {
        return $this->onlyFailed()->pluck('node_id')->diff($nodesPreviouslyDown);
    }

    public function onlyFailed()
    {
        return $this->filter(fn(WebCheckResult $webCheckResult) => $webCheckResult->isFailed());
    }

    public function getNewSuccessful(Collect $nodesPreviouslyDown)
    {
        return $this->onlySuccessful()->pluck('node_id')->intersect($nodesPreviouslyDown);
    }

    public function onlySuccessful()
    {
        return $this->filter(fn(WebCheckResult $webCheckResult) => $webCheckResult->isSuccessful());
    }

    public function mapToMetaForProcessing()
    {
        return [
            'header' => ['Location', 'Reason', 'Status'],
            'align'  => [
                MarkdownTableBuilder::LEFT,
                MarkdownTableBuilder::LEFT,
                MarkdownTableBuilder::RIGHT,
            ],
            'values' => $this->sortBy('node.short_name')->map(fn(WebCheckResult $result) => [
                $result->node->short_name,
                $result->reason ?? 'n/a',
                $result->status->description,
            ])->all(),
        ];
    }

    /**
     * @return \App\Support\Mail\MarkdownTableBuilder
     * @deprecated
     */
    public function formatResultsAsMarkdownTable(): MarkdownTableBuilder
    {
        return resolve(MarkdownTableBuilder::class)
            ->headers('Location', 'Reason', 'Time', 'Status')
            ->align(
                MarkdownTableBuilder::LEFT,
                MarkdownTableBuilder::LEFT,
                MarkdownTableBuilder::CENTER,
                MarkdownTableBuilder::RIGHT,
            )
            ->rows(...$this->map(fn(WebCheckResult $webCheckResult) => [
                $webCheckResult->node->short_name,
                $webCheckResult->reason ?? 'n/a',
                $webCheckResult->check_time,
                $webCheckResult->status->description,
            ]));
    }
}
