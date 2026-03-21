<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SalesOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'sales') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
