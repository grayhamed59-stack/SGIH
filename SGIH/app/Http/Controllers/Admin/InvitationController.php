<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function index()
    {
        // Only superadmins should access this
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
            'role' => 'required|in:admin,doctor',
            'email' => 'nullable|email|max:255',
        ]);

        // Generate a unique 8-character uppercase code
        $code = strtoupper(Str::random(8));
        
        // Ensure uniqueness
        while (Invitation::where('code', $code)->exists()) {
            $code = strtoupper(Str::random(8));
        }

        Invitation::create([
            'code' => $code,
            'role' => $request->role,
            'email' => $request->email,
            'created_by' => Auth::id(),
            'expires_at' => now()->addDays(7), // Expires in 7 days
        ]);

        return redirect()->route('admin.invitations.index')->with('success', 'Code d\'invitation généré avec succès : ' . $code);
    }
}
