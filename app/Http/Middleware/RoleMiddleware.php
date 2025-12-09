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
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        // Admins can access routes for any role
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Support multiple roles passed to the middleware (comma or pipe separated)
        $allowed = preg_split('/[|,]/', $role, -1, PREG_SPLIT_NO_EMPTY);

        if (! in_array($user->role, $allowed, true)) {
            abort(403);
        }

        return $next($request);
    }
}
