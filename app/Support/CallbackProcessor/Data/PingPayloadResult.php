<?php

namespace App\Support\CallbackProcessor\Data;

use App\Data\Casters\EnumCaster;
use App\Enums\PingResultStatus;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
final class PingPayloadResult extends PayloadResult
{
    public string $connect;

    #[CastWith(EnumCaster::class)]
    public PingResultStatus $status;
}
