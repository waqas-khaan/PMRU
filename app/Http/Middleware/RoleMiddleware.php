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
     * Usage in routes:
     * Route::middleware(['auth', 'role:Admin'])->group(...);
     * Route::middleware(['auth', 'role:Admin,Teacher'])->group(...);
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // If user is not logged in just let the auth middleware handle it
        if (! $request->user()) {
            return redirect()->route('auth.login');
        }

        // If no specific roles were passed, just continue
        if (empty($roles)) {
            return $next($request);
        }

        // Check if the user has at least one of the required roles
        $hasRole = $request->user()
            ->roles()
            ->whereIn('name', $roles)
            ->exists();

        if (! $hasRole) {
            // You can change this to abort(403) if you prefer
            return redirect()
                ->route('auth.dashboard')
                ->with('error', 'You are not authorized to access that page.');
        }

        return $next($request);
    }
}
