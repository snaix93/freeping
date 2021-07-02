<?php

namespace App\Support\CallbackProcessor\Data;

use App\Support\CallbackProcessor\Collections\ScanPayloadResultCollection;
use App\Support\CallbackProcessor\Data\Casters\ScanPayloadResultCollectionCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
final class ScanPayload extends Payload
{
    #[CastWith(ScanPayloadResultCollectionCaster::class)]
    public ScanPayloadResultCollection $results;
}
