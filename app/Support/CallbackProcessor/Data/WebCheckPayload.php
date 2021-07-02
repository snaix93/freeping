<?php

namespace App\Support\CallbackProcessor\Data;

use App\Support\CallbackProcessor\Collections\WebCheckPayloadResultCollection;
use App\Support\CallbackProcessor\Data\Casters\WebCheckPayloadResultCollectionCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
final class WebCheckPayload extends Payload
{
    #[CastWith(WebCheckPayloadResultCollectionCaster::class)]
    public WebCheckPayloadResultCollection $results;
}
