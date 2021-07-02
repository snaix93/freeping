<?php

namespace App\Support\CallbackProcessor\Data;

use App\Data\Casters\DatetimeCaster;
use App\Data\Casters\EnumCaster;
use App\Data\Casters\UpperCaseTrimCaster;
use App\Support\CallbackProcessor\Enums\JobType;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

abstract class Payload extends DataTransferObject
{
    #[CastWith(UpperCaseTrimCaster::class)]
    public string $nodeId;

    public string $batchId;

    #[CastWith(EnumCaster::class)]
    public JobType $jobType;

    public int $jobDurationInSeconds;

    #[CastWith(DatetimeCaster::class)]
    public Carbon $date;
}
