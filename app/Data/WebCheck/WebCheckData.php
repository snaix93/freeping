<?php

namespace App\Data\WebCheck;

use App\Data\Casters\LowerCaseTrimCaster;
use App\Data\Casters\UpperCaseTrimCaster;
use App\Data\WebCheck\Casters\WebCheckHeadersCaster;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class WebCheckData extends DataTransferObject
{
    #[CastWith(LowerCaseTrimCaster::class)]
    public string $url;

    #[CastWith(LowerCaseTrimCaster::class)]
    public string $protocol;

    #[CastWith(LowerCaseTrimCaster::class)]
    public string $host;

    public ?int $port;

    #[CastWith(LowerCaseTrimCaster::class)]
    public ?string $path;

    #[CastWith(LowerCaseTrimCaster::class)]
    public ?string $query;

    #[CastWith(LowerCaseTrimCaster::class)]
    public ?string $fragment;

    #[CastWith(UpperCaseTrimCaster::class)]
    public string $method;

    public int $expectedHttpStatus;

    public ?string $expectedPattern = null;

    #[CastWith(WebCheckHeadersCaster::class)]
    public ?array $headers = null;

    public ?bool $searchHtmlSource = null;
}
