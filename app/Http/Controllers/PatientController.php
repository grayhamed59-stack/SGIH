<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('patients.create');
    }

    // Enregistrer un nouveau patient
    public function store(Request $request)
    {
        // 1. Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'genre' => 'required|in:M,F',
            'telephone' => 'nullable|string',
            'adresse' => 'nullable|string',
        ]);

        // 2. Création dans la base de données
        Patient::create($validated);

        // 3. Redirection avec un message de succès
        return redirect()->route('patients.index')->with('success', 'Patient enregistré avec succès !');
    }
}
