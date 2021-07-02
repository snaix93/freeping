<?php

namespace App\Support\CallbackProcessor\Data;

use App\Data\Casters\EnumCaster;
use App\Enums\ScanResultStatus;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
final class ScanPayloadResult extends PayloadResult
{
    public string $connect;

    #[CastWith(EnumCaster::class)]
    public ScanResultStatus $status;

    public int $port;
}
