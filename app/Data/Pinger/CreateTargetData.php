<?php

namespace App\Data\Pinger;

use App\Data\Casters\LowerCaseTrimCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class CreateTargetData extends DataTransferObject
{
    #[CastWith(LowerCaseTrimCaster::class)]
    public string $pingTarget;

    /** @var int[] */
    public array $ports;
}
