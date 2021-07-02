<?php

namespace App\Http\Middleware;

use App\Models\Node;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthenticateBearerToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = (string) Str::of($request->header('authorization'))->remove('Bearer ')->trim();

        abort_unless(Node::whereCallbackToken($token)->exists(), 403);
        
        return $next($request);
    }
}
