<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PingResultQueryBuilder extends Builder
{
    public function withOrderedNodes(): self
    {
        return $this
            ->select([
                'ping_results.id',
                'ping_results.status',
                'ping_results.connect',
                'ping_results.node_id',
                'ping_results.updated_at',
                'nodes.short_name as node_short_name',
                'nodes.country',
            ])
            ->without('node')
            ->leftJoin('nodes', 'node_id', '=', 'nodes.id')
            ->orderBy('node_short_name');
    }
}
