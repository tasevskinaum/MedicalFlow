<?php

namespace App\Middleware;

use App\Http\Models\Role;
use Core\Middleware\BaseMiddleware;

class SuperAdminMiddleware extends BaseMiddleware
{
    public function handle($request, $next)
    {
        $superAdmin = Role::where('name', '=', 'super_admin')[0];

        if (auth()->user()->role_id != $superAdmin->id) {
            return redirect('/admin/dashboard');
        }

        $next($request);
    }
}
