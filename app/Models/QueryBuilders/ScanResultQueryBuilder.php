<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ScanResultQueryBuilder extends Builder
{
    public function withOrderedNodes()
    {
        return $this
            ->select([
                'scan_results.id',
                'scan_results.status',
                'scan_results.connect',
                'scan_results.port',
                'scan_results.node_id',
                'scan_results.updated_at',
                'nodes.short_name as node_short_name',
                'nodes.country',
            ])
            ->without('node')
            ->leftJoin('nodes', 'node_id', '=', 'nodes.id')
            ->orderBy('node_short_name');
    }
}
