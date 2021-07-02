<?php

namespace App\Actions\WebCheck;

use App\Data\WebCheck\WebCheckData;
use App\Enums\WebCheckStatus;
use App\Models\WebCheck;

class UpdateWebCheckAction
{
    public function __invoke(WebCheck $webCheck, WebCheckData $webCheckData): WebCheck
    {
        $webCheck->update([
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
        ]);

        return $webCheck;
    }
}
