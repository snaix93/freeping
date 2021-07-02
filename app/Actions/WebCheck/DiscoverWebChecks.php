<?php

namespace App\Actions\WebCheck;

use App\Support\UrlParser;
use App\Validation\IpValidator;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DiscoverWebChecks
{
    public function __invoke($connect): Collection
    {
        if (IpValidator::isValid($connect)) {
            return collect();
        }

        $urlParser = UrlParser::for($connect);

        $key = 'discovery::web-check::'.$urlParser->sansProtocol();
        $ttl = now()->addMinutes(5);
        $httpUrl = $urlParser->httpUrl();
        $httpsUrl = $urlParser->httpsUrl();

        return Cache::remember($key, $ttl, function () use ($httpsUrl, $httpUrl) {

            $responses = Http::pool(fn(Pool $pool) => [
                $pool->as('http')->timeout(5)
                    ->withoutRedirecting()->withoutVerifying()->get($httpUrl),
                $pool->as('https')->timeout(5)
                    ->withoutRedirecting()->withoutVerifying()->get($httpsUrl),
            ]);

            return with(collect(), function ($return) use ($httpsUrl, $httpUrl, $responses) {
                if ($this->httpPingWasSuccessful($responses['http'])) {
                    $return->push($httpUrl);
                }

                if ($this->httpPingWasSuccessful($responses['https'])) {
                    $return->push($httpsUrl);
                }

                return $return;
            });
        });
    }

    private function httpPingWasSuccessful(Response|Exception $response): bool
    {
        if (is_a($response, ConnectException::class)) {
            return false;
        }

        if ($response->failed()) {
            return false;
        }

        if (! $response->successful()) {
            return false;
        }

        return true;
    }
}
