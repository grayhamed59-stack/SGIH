<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ForcePasswordChangeController extends Controller
{
    /**
     * Show the forced password change form.
     */
    public function show(): View
    {
        return view('auth.force-password-change');
    }

    /**
     * Validate and save the new secure password.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->uncompromised(),
            ],
        ], [
            'password.required'   => 'Le nouveau mot de passe est obligatoire.',
            'password.confirmed'  => 'Les deux mots de passe ne correspondent pas.',
            'password.min'        => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $user = $request->user();

        $user->update([
            'password'            => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect()->route($user->dashboardRoute())
            ->with('success', '✅ Mot de passe mis à jour avec succès. Bienvenue dans votre espace SGIH HospiCare !');
    }
}
