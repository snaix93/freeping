<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class BatchQueryBuilder extends Builder
{
    public function finished(): self
    {
        return $this->whereNotNull('finished_at');
    }
}
