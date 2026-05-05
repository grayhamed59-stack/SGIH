<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $patients = $query->orderBy('created_at', 'desc')->get();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Masculin,Féminin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:Actif,En attente',
        ]);

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Patient enregistré avec succès.');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:Masculin,Féminin',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:Actif,En attente',
        ]);

        $patient->update($validated);

        if ($request->has('from_dashboard')) {
            return redirect()->route('dashboard')->with('info', 'Statut mis à jour.');
        }

        return redirect()->route('patients.index')->with('info', 'Informations du patient mises à jour.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete(); // This is now a soft delete
        return redirect()->back()->with('warning', 'Dossier patient archivé avec succès.');
    }

    public function export()
    {
        $patients = Patient::all();
        $csvFileName = 'patients_export_' . now()->format('Y_m_d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $handle = fopen('php://output', 'w');
        // Add UTF-8 BOM for Excel compatibility
        fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($handle, ['ID', 'Nom', 'Prénom', 'Date de Naissance', 'Genre', 'Téléphone', 'Statut', 'Date Enregistrement'], ';');

        foreach ($patients as $patient) {
            fputcsv($handle, [
                $patient->id,
                $patient->last_name,
                $patient->first_name,
                $patient->birth_date,
                $patient->gender,
                $patient->phone,
                $patient->status,
                $patient->created_at->format('Y-m-d H:i')
            ], ';');
        }

        fclose($handle);

        return response()->stream(function() {}, 200, $headers);
    }
}

