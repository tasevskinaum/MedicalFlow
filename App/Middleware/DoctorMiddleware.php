<?php

namespace App\Middleware;

use App\Http\Models\Role;
use Core\Middleware\BaseMiddleware;

class DoctorMiddleware extends BaseMiddleware
{
    public function handle($request, callable $next)
    {
        $admin = Role::queryBuilder()
            ->where('name', '=', 'doctor')
            ->first();

        if (auth()->user()->role_id != $admin->id) {
            return redirect('/dashboard');
        }

        $next($request);
    }
}
