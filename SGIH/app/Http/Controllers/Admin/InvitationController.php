<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OtpInvitationMail;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        $invitations = Invitation::with('creator')->orderBy('created_at', 'desc')->get();
        return view('admin.invitations.index', compact('invitations'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'role'  => 'required|in:receptionist,doctor,accountant',
            'email' => 'required|email|max:255',
        ]);

        // Generate a unique 6-digit numeric OTP code
        do {
            $code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        } while (Invitation::where('code', $code)->exists());

        $invitation = Invitation::create([
            'code'       => $code,
            'role'       => $request->role,
            'email'      => $request->email,
            'created_by' => Auth::id(),
            'expires_at' => now()->addDays(7),
        ]);

        // Try sending the email (using log driver in dev)
        try {
            Mail::to($request->email)->send(new OtpInvitationMail($invitation));
            Log::info("SGIH OTP Email envoyé à {$request->email} - Code: {$code} - Rôle: {$request->role}");
            $message = "Code OTP généré et envoyé à {$request->email} : {$code}";
        } catch (\Exception $e) {
            Log::error("Échec envoi OTP: " . $e->getMessage());
            $message = "Code généré : {$code} (Email non envoyé - voir les logs Laravel).";
        }

        return redirect()->route('admin.invitations.index')->with('success', $message);
    }

    public function destroy(Invitation $invitation)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Unauthorized action.');
        }
        $invitation->delete();
        return redirect()->route('admin.invitations.index')->with('success', 'Invitation supprimée.');
    }
}
