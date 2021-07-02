<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RejectLargePayload
{
    private int $maxAllowedPayloadSize = 65536; //64k

    public function handle(Request $request, Closure $next)
    {
        $this->validate((int)$request->header('content-length'));
        // The announced content-length is just a header that can be set to anything. We cannot rely on it.
        $this->validate(strlen(json_encode($request->input())));

        return $next($request);
    }

    private function validate($contentLength)
    {
        abort_if($contentLength > $this->maxAllowedPayloadSize, response()->json([
            'success' => false,
            'error'   => sprintf('Content Length exceeds the maximum allowed of %d bytes (%d kB)', $this->maxAllowedPayloadSize, $this->maxAllowedPayloadSize/1024),
        ], 400,[],JSON_PRETTY_PRINT));
    }
}
