<?php

namespace App\Middleware;

use Core\Middleware\BaseMiddleware;

class GuestMiddleware extends BaseMiddleware
{
    public function handle($request, callable $next)
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        $next($request);
    }
}
