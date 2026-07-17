<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\LabRequest;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'like', $searchTerm)
                  ->orWhere('last_name', 'like', $searchTerm)
                  ->orWhere('phone', 'like', $searchTerm);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $patients = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $doctors = \App\Models\Doctor::all();

        return view('patients.index', compact('patients', 'doctors'));
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

    public function storeLabRequest(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'test_type' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        LabRequest::create($validated);

        return redirect()->route('patients.index')->with('success', "Demande d'analyse (" . $validated['test_type'] . ") envoyée au laboratoire avec succès.");
    }

    public function storeAdmission(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'room_number' => 'nullable|string|max:20',
            'reason' => 'required|string|max:1000',
        ]);

        Admission::create($validated);
        
        // Update patient status to Hospitalisé
        Patient::where('id', $validated['patient_id'])->update(['status' => 'Hospitalisé']);

        return redirect()->route('patients.index')
            ->with('success', 'Le dossier d\'hospitalisation a été créé avec succès.');
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'reason'     => 'nullable|string|max:1000',
            'amount'     => 'required|numeric|min:1',
        ]);

        // 1. Créer le rendez-vous (Statut pending par défaut)
        $appointment = Appointment::create([
            'patient_id'       => $request->patient_id,
            'doctor_id'        => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'reason'           => $request->reason,
            'status'           => 'pending',
        ]);

        // 2. Créer la facture associée
        Payment::create([
            'patient_id'     => $request->patient_id,
            'appointment_id' => $appointment->id,
            'amount'         => $request->amount,
            'description'    => 'Consultation Médicale',
            'status'         => 'pending',
        ]);

        // 3. Notifier les superadmins et le médecin
        $superadmins = \App\Models\User::where('role', 'superadmin')->get();
        \Illuminate\Support\Facades\Notification::send($superadmins, new \App\Notifications\AppointmentCreatedNotification($appointment));
        
        if ($appointment->doctor && $appointment->doctor->user) {
            $appointment->doctor->user->notify(new \App\Notifications\AppointmentCreatedNotification($appointment));
        }

        return redirect()->route('patients.index')
            ->with('success', 'Rendez-vous créé ! La facture a été envoyée à la caisse.');
    }
}
