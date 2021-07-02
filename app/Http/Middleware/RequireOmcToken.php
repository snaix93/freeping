<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Illuminate\Support\Str;

class RequireOmcToken extends Middleware
{
    public function handle($request, Closure $next)
    {
        $token = (string) Str::of($request->header('OMC-TOKEN'))->trim();
        $link = 'https://docs.cloudradar.io/freeping.io/open-monitoring-connector';

        abort_if(blank($token), response()->json([
            'success' => false,
            'error'   => "No OMC-TOKEN header sent.",
            'help'    => $link,
        ], 401, [], JSON_PRETTY_PRINT));

        abort_unless(strlen($token) === 21, response()->json([
            'success' => false,
            'error'   => 'Bad OMC-TOKEN',
            'help'    => $link,
        ], 401, [], JSON_PRETTY_PRINT));

        return $next($request);
    }
}
