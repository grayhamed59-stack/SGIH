<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function cancel(Request $request, Appointment $appointment)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:1000',
        ]);

        $appointment->update([
            'status'        => 'cancelled',
            'cancel_reason' => $request->cancel_reason,
        ]);

        return redirect()->back()->with('warning', 'Le rendez-vous a été annulé.');
    }

    /**
     * Show the consultation form for a specific appointment.
     */
    public function startConsultation(Appointment $appointment)
    {
        // Only the assigned doctor can start
        $appointment->load('patient');
        return view('doctor.consultation', compact('appointment'));
    }

    /**
     * Store the consultation notes and mark appointment as completed.
     */
    public function storeConsultation(Request $request, Appointment $appointment)
    {
        $request->validate([
            'symptoms'     => 'required|string|max:2000',
            'diagnosis'    => 'required|string|max:2000',
            'prescription' => 'nullable|string|max:2000',
            'notes'        => 'nullable|string|max:2000',
        ]);

        // Create or update the consultation
        Consultation::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'symptoms'     => $request->symptoms,
                'diagnosis'    => $request->diagnosis,
                'prescription' => $request->prescription,
                'notes'        => $request->notes,
            ]
        );

        // Mark appointment as completed
        $appointment->update(['status' => 'completed']);

        return redirect()->route('doctor.dashboard')
            ->with('success', 'Consultation enregistrée avec succès.');
    }
}
