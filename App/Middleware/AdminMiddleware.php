<?php

namespace App\Middleware;

use App\Http\Models\Role;
use Core\Middleware\BaseMiddleware;

class AdminMiddleware extends BaseMiddleware
{
    public function handle($request, $next)
    {
        $admin = Role::where('name', '=', 'admin')[0];

        if (auth()->user()->role_id != $admin->id) {
            return redirect('/dashboard');
        }

        $next($request);
    }
}
