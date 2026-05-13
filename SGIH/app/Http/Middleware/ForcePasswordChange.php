<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Redirect users who haven't changed their temporary password yet.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // If logged in and must change password, redirect (unless already on the change page)
        if ($user && $user->must_change_password) {
            if (!$request->routeIs('password.change', 'password.change.update', 'logout')) {
                return redirect()->route('password.change')
                    ->with('warning', 'Veuillez créer votre mot de passe sécurisé avant de continuer.');
            }
        }

        return $next($request);
    }
}
