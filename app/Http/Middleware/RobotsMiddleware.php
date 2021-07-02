<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class RobotsMiddleware extends \Spatie\RobotsMiddleware\RobotsMiddleware
{
    protected function shouldIndex(Request $request)
    {
        return app()->environment('production');
    }
}
