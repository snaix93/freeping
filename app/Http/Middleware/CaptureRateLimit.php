<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CaptureRateLimit
{
    public function handle(Request $request, Closure $next)
    {
        if((bool) env('DISABLE_RATE_LIMIT',false)) {
            return $next($request);
        }
        $token = (string)Str::of($request->header('omc-token'))->trim();
        $captureId = (string)$request->input('id', '0');
        $cacheKey = md5('requestByOmcTokenAndHostAndCapture' . $token . $request->input('hostname').$captureId);
        $ttl = 45;
        abort_if(cache($cacheKey), response()->json([
            'success' => false,
            'error'   => sprintf("Wait %d seconds between capture requests", $ttl),
            'help'    => 'https://docs.cloudradar.io/freeping.io/open-monitoring-connector',
        ], 429));
        cache([$cacheKey => 1], $ttl);

        return $next($request);
    }
}
