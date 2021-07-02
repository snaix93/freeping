<?php

namespace App\Models;

use App\Enums\PushoverPriority;
use Parental\HasParent;

/**
 * @mixin IdeHelperPushover
 */
class Pushover extends Recipient
{
    use HasParent;

    protected $attributes = [
        'alerts'     => true,
        'warnings'   => true,
        'recoveries' => false,
    ];

    public function getPriorityAttribute(): PushoverPriority
    {
        return PushoverPriority::coerce((int) $this->meta->priority);
    }

    public function getPushoverKeyAttribute(): ?string
    {
        return $this->meta->key;
    }
}
