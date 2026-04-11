<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next, $role): Response
{
    if (!auth()->check()) {
        return redirect('/login');
    }

    // Check if user has role
    if (!$request->user()->role) {
        abort(403, 'No role assigned');
    }

    // Match role name
    if ($request->user()->role->name !== $role) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
}
}
