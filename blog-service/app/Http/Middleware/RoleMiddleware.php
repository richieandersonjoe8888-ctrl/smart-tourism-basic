<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // If the user isn't logged in, or doesn't have the required role, block them immediately
        if (!Auth::check() || !$request->user()->hasRole($role)) {
            abort(403, 'Unauthorized access to this service node.');
        }

        return $next($request);
    }
}
