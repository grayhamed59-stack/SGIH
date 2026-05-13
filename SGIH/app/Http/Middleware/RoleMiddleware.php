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
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // User must be authenticated
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Check if user's role matches any of the allowed roles
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Accès non autorisé. Vous n\'avez pas les droits pour accéder à cette page.');
        }

        return $next($request);
    }
}
