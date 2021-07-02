<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class WebCheckResultQueryBuilder extends Builder
{
    public function withOrderedNodes(): self
    {
        return $this
            ->select([
                'web_check_results.id',
                'web_check_results.status',
                'web_check_results.uuid',
                'web_check_results.node_id',
                'web_check_results.reason',
                'web_check_results.updated_at',
                'nodes.short_name as node_short_name',
                'nodes.country',
            ])
            ->without('node')
            ->leftJoin('nodes', 'node_id', '=', 'nodes.id')
            ->orderBy('node_short_name');
    }
}
