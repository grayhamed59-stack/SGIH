<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OtpLoginController extends Controller
{
    /**
     * Show the OTP verification form.
     * Expects an email in the session from a previous step.
     */
    public function show(): View
    {
        return view('auth.otp-login');
    }

    /**
     * Verify the OTP code and log the user in.
     */
    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp'   => ['required', 'string', 'size:6'],
        ], [
            'otp.size'     => 'Le code OTP doit contenir exactement 6 chiffres.',
            'otp.required' => 'Le code OTP est obligatoire.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->hasValidOtp($request->otp)) {
            return back()->withErrors([
                'otp' => 'Code OTP invalide ou expiré. Veuillez contacter l\'administrateur.',
            ])->withInput(['email' => $request->email]);
        }

        // Clear the OTP after successful use
        $user->clearOtp();

        // Log the user in
        Auth::login($user);
        $request->session()->regenerate();

        // Force password change on first access
        return redirect()->route('password.change')
            ->with('info', 'Code OTP validé ! Définissez maintenant votre mot de passe personnel et sécurisé.');
    }
}
