<?php

namespace App\Middleware;

use App\Http\Models\Role;
use Core\Middleware\BaseMiddleware;

class SuperAdminMiddleware extends BaseMiddleware
{
    public function handle($request, callable $next)
    {
        $superAdmin = Role::queryBuilder()
            ->where('name', '=', 'super_admin')
            ->first();

        if (auth()->user()->role_id != $superAdmin->id) {
            return redirect('/dashboard');
        }

        $next($request);
    }
}
