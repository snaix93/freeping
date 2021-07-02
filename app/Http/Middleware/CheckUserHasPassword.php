<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class CheckUserHasPassword
{
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->passwordMissing($request)) {
            return $this->responseFactory->redirectToRoute('create-password.index');
        }

        return $next($request);
    }

    protected function passwordMissing($request): bool
    {
        return ! is_null(value($user = $request->user())) && is_null($user->password);
    }
}
