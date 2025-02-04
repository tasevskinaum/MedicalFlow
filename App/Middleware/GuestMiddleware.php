<?php

namespace App\Middleware;

use Core\Middleware\BaseMiddleware;

class GuestMiddleware extends BaseMiddleware
{
    public function handle($request, $next)
    {
        if (auth()->check()) {
            return redirect('/admins');
        }

        $next($request);
    }
}
