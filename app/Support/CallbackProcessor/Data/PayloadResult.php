<?php

namespace App\Support\CallbackProcessor\Data;

use Spatie\DataTransferObject\DataTransferObject;

abstract class PayloadResult extends DataTransferObject
{
    public string $inProgressIdentifier;

    public ?string $reason;

    public int $failureCount;
}
