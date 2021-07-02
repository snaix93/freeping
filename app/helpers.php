<?php

use App\Models\Target;
use App\Models\User;
use App\Models\WebCheck;
use Illuminate\Auth\Authenticatable;

if (! function_exists('environment')) {
    /**
     * @param  null|string  $key
     * @return bool
     */
    function environment($key = null)
    {
        if (is_null($key)) {
            return app()->environment();
        }

        return app()->environment($key);
    }
}

if (! function_exists('resolve_mailing_list_entity')) {
    function resolve_mailing_list_entity(?string $mailingList = null): null|Target|WebCheck
    {
        if (! $mailingList) {
            return null;
        }

        [$type, $id] = explode('::', $mailingList);

        return match ($type) {
            'ping' => Target::findByOId($id),
            'web-check' => WebCheck::findByOId($id),
        };
    }
}

if (! function_exists('user')) {
    function user($guard = null): null|Authenticatable|User
    {
        return auth($guard)->user();
    }
}

if (! function_exists('normalise_url')) {
    function normalise_url($url): array
    {
        $targetSansProtocol = Str::of($url)->after('://');

        return [
            (string) $targetSansProtocol,
            "http://{$targetSansProtocol}",
            "https://{$targetSansProtocol}",
        ];
    }
}

if (! function_exists('nanoid')) {
    /**
     * Return a 21bit nano id
     *
     * @return string
     */
    function nanoid(): string
    {
        $nanoClient = new Hidehalo\Nanoid\Client();

        return $nanoClient->generateId(size: 21, mode: $nanoClient::MODE_DYNAMIC);
    }
}

if (! function_exists('fluxNow')) {
    /**
     * Return the current date and time at nanosecond precision to be used in InfluxDB
     *
     * @return string
     */
    function fluxNow(): string
    {
        return (new DateTime())->format("Y-m-d\TH:i:s.u000\Z");
    }
}
