<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReceptionistController extends Controller
{
    /**
     * Display the receptionist dashboard.
     * Shows today's appointments and recent patient list.
     */
    public function dashboard()
    {
        $today = Carbon::today();

        return view('receptionist.dashboard', [
            'todayAppointments' => Appointment::with(['patient', 'doctor'])
                ->whereDate('appointment_date', $today)
                ->orderBy('appointment_date')
                ->get(),
            'patientsCount'   => Patient::count(),
            'pendingCount'    => Appointment::where('status', 'pending')->count(),
            'confirmedCount'  => Appointment::whereDate('appointment_date', $today)
                ->where('status', 'confirmed')->count(),
            'recentPatients'  => Patient::orderBy('created_at', 'desc')->take(5)->get(),
        ]);
    }
}
