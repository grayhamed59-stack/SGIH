<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecin;

class MedecinController extends Controller
{
    // php artisan make:controller MedecinController
    public function store(Request $request) {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'specialite' => 'required|string',
            'email' => 'required|email|unique:medecins',
            'telephone' => 'required|string',
        ]);

        Medecin::create($validated);

        return redirect()->route('medecins.index')->with('success', 'Médecin ajouté !');
    }

}
