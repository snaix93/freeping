<?php

namespace App\Actions\WebCheck;

use App\Collections\WebCheckDataCollection;
use App\Data\WebCheck\WebCheckData;
use App\Enums\WebCheckStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CreateWebChecksAction
{
    public function __invoke(User $user, WebCheckDataCollection $webCheckDataCollection)
    {
        return DB::transaction(
            fn() => $this->createWebChecks($user, $webCheckDataCollection)
        );
    }

    private function createWebChecks(
        User $user,
        WebCheckDataCollection $webCheckDataCollection
    ): Collection {
        return $user->webChecks()->createMany(
            $webCheckDataCollection->map(fn(WebCheckData $webCheckData) => [
                'url'                  => $webCheckData->url,
                'protocol'             => $webCheckData->protocol,
                'host'                 => $webCheckData->host,
                'port'                 => $webCheckData->port,
                'path'                 => $webCheckData->path,
                'query'                => $webCheckData->query,
                'fragment'             => $webCheckData->fragment,
                'method'               => $webCheckData->method,
                'expected_pattern'     => $webCheckData->expectedPattern,
                'expected_http_status' => $webCheckData->expectedHttpStatus,
                'headers'              => $webCheckData->headers,
                'search_html_source'   => $webCheckData->searchHtmlSource,
                'status'               => WebCheckStatus::AwaitingResult(),
            ])->values()
        );
    }
}
