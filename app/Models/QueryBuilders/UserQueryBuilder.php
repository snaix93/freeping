<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function verified(): self
    {
        return $this->whereNotNull('email_verified_at');
    }

    public function didntJoinToday(): self
    {
        return $this->whereDate('created_at', '<', today());
    }
}
