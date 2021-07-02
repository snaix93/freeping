<?php

namespace App\Http\Middleware;

use App\Support\Backdoor;
use Closure;
use Illuminate\Http\Request;
use Lukeraymonddowning\Honey\Facades\Honey;

class BackdoorCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (Backdoor::isOpen()) {
            Honey::disable();
        }

        return $next($request);
    }
}
