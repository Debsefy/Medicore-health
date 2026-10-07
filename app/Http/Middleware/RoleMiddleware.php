<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!auth()->check()) return redirect()->route('login');

        if (!empty($roles) && !auth()->user()->hasRole($roles)) {
            abort(403, 'Unauthorized. You do not have access to this resource.');
        }

        return $next($request);
    }
}
