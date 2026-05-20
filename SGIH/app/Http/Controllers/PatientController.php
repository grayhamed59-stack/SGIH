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

    public function export(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $patients = $query->orderBy('created_at', 'desc')->get();
        $fileName = 'patients_sgih_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($patients) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM so Excel opens accents and French characters correctly
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'ID',
                'Nom',
                'Prénom',
                'Date de naissance',
                'Genre',
                'Téléphone',
                'Adresse',
                'Statut',
                'Date enregistrement',
            ], ';');

            foreach ($patients as $patient) {
                fputcsv($handle, [
                    $patient->id,
                    $patient->last_name,
                    $patient->first_name,
                    $patient->birth_date
                        ? \Illuminate\Support\Carbon::parse($patient->birth_date)->format('d/m/Y')
                        : '',
                    $patient->gender,
                    $patient->phone ?? '',
                    $patient->address ?? '',
                    $patient->status ?? '',
                    $patient->created_at?->format('d/m/Y H:i') ?? '',
                ], ';');
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}

