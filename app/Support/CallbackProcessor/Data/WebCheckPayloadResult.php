<?php

namespace App\Support\CallbackProcessor\Data;

use App\Data\Casters\EnumCaster;
use App\Enums\WebCheckResultStatus;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
final class WebCheckPayloadResult extends PayloadResult
{
    #[CastWith(EnumCaster::class)]
    public WebCheckResultStatus $status;

    public string $id;

    public string $url;

    public float $totalTimeSpentInSeconds;
}
