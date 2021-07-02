<?php

namespace App\Models\QueryBuilders;

use App\Enums\TargetStatus;
use Illuminate\Database\Eloquent\Builder;

class TargetQueryBuilder extends Builder
{
    public function alive(): self
    {
        return $this->where('targets.status', TargetStatus::Online());
    }
}
