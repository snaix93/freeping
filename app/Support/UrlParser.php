<?php

namespace App\Support;

use Illuminate\Support\Str;

class UrlParser
{
    public string $sansProtocol;

    public string $httpUrl;

    public string $httpsUrl;

    public string $protocol = 'https';

    public string $host;

    public ?int $port = null;

    public ?string $path = null;

    public ?string $query = null;

    public ?string $fragment = null;

    public function __construct(public string $url) { }

    public static function for(string $url): self
    {
        return tap(new self(Str::of($url)->trim()->lower()))->parse();
    }

    public function parse()
    {
        [$sansProtocol, $httpUrl, $httpsUrl] = $this->normalise();

        $this->sansProtocol = $sansProtocol;
        $this->httpUrl = $httpUrl;
        $this->httpsUrl = $httpsUrl;

        $parts = parse_url(str_contains($this->url, '://') ? $this->url : $httpsUrl);

        $this->protocol = data_get($parts, 'scheme', 'https');
        $this->host = data_get($parts, 'host', $this->url);
        $this->port = data_get($parts, 'port');
        $this->path = data_get($parts, 'path');
        $this->query = data_get($parts, 'query');
        $this->fragment = data_get($parts, 'fragment');
    }

    protected function normalise(): array
    {
        $sansProtocol = Str::of($this->url)->after('://');

        return [
            (string) $sansProtocol,
            "http://{$sansProtocol}",
            "https://{$sansProtocol}",
        ];
    }

    public function sansProtocol(): string
    {
        return $this->sansProtocol;
    }

    public function httpUrl(): string
    {
        return $this->httpUrl;
    }

    public function httpsUrl(): string
    {
        return $this->httpsUrl;
    }

    public function protocol(): string
    {
        return $this->protocol;
    }

    public function host(): string
    {
        return $this->host;
    }

    public function port(): ?int
    {
        return $this->port;
    }

    public function path(): ?string
    {
        return $this->path;
    }

    public function query(): ?string
    {
        return $this->query;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function fragment(): ?string
    {
        return $this->fragment;
    }
}
