<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\Medecin;

class prescriptionController extends Controller
{
    public function show($id)
    {
        $prescription = Prescription::find($id);
            return "Prescrit par le Dr. " . $prescription->medecin->nom;
    }
    public function create()
    {
        $patients = Patient::all();
        $medecins = Medecin::all();
            return view('prescriptions.create', compact('patients', 'medecins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medecin_id' => 'required|exists:medecins,id',
            'medicaments' => 'required|string',
            'instructions' => 'required|string',
            'date_prescription' => 'required|date',
        ]);

        Prescription::create($validated);
            return redirect()->route('prescriptions.index')->with('success', 'Ordonnance enregistrée.');
    }
}

