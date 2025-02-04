<?php

namespace App\Middleware;

use Core\Middleware\BaseMiddleware;

class AuthMiddleware extends BaseMiddleware
{
    public function handle($request, $next)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $next($request);
    }
}
