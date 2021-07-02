<?php

namespace App\Support\CallbackProcessor\Data;

use App\Support\CallbackProcessor\Collections\PingPayloadResultCollection;
use App\Support\CallbackProcessor\Data\Casters\PingPayloadResultCollectionCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
final class PingPayload extends Payload
{
    #[CastWith(PingPayloadResultCollectionCaster::class)]
    public PingPayloadResultCollection $results;
}
