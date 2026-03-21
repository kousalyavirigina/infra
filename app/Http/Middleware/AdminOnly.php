<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            abort(403);
        }

        $user = auth()->user();

        // allow admin access safely
        if (
            $user->role === 'admin' ||
            $user->role === 'Admin' ||
            $user->role === 1 ||
            $user->role === 'superadmin'
        ) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
