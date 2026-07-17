<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware('role:superadmin,doctor')
     *
     * Instead of returning a generic 403 error page,
     * we redirect the user to THEIR OWN dashboard with a warning message.
     * This is more professional and prevents confusion in a multi-role app.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // User must be authenticated
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Check if user's role matches any of the allowed roles
        if (!in_array($request->user()->role, $roles)) {
            $dashboardRoute = $request->user()->dashboardRoute();

            return response()->view('errors.403', [
                'allowedRoles' => $roles,
                'currentRole' => $request->user()->role,
                'dashboardRoute' => $dashboardRoute
            ], 403);
        }

        return $next($request);
    }
}
