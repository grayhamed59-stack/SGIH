<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'patientsCount' => \App\Models\Patient::count(),
        'doctorsCount' => \App\Models\Doctor::count(),
        'appointmentsCount' => \App\Models\Appointment::count(),
        'recentPatients' => \App\Models\Patient::orderBy('created_at', 'desc')->take(5)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/patients/export', [PatientController::class, 'export'])->name('patients.export');
    Route::resource('patients', PatientController::class);
    
    // Interface Propriétaire / SuperAdmin
    Route::get('/superadmin/dashboard', function () {
        if (Auth::user()->role !== 'superadmin') { abort(403); }
        return view('superadmin.dashboard', [
            'patientsCount' => \App\Models\Patient::count(),
            'doctorsCount' => \App\Models\Doctor::count(),
            'appointmentsCount' => \App\Models\Appointment::count(),
            // Revenu réel basé sur les paiements encaissés AUJOURD'HUI
            'revenue' => \App\Models\Payment::where('status', 'paid')
                ->whereDate('created_at', \Illuminate\Support\Carbon::today())
                ->sum('amount'),
            'totalRevenue' => \App\Models\Payment::where('status', 'paid')->sum('amount'),
            'cancellationsCount' => \App\Models\Appointment::where('status', 'cancelled')->count(),
        ]);
    })->name('superadmin.dashboard');

    Route::put('/appointments/{appointment}/cancel', [\App\Http\Controllers\AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Interface Médecin
    Route::get('/doctor/dashboard', function () {
        if (Auth::user()->role !== 'doctor') { abort(403); }
        return view('doctor.dashboard', [
            'appointmentsList' => \App\Models\Appointment::with(['patient', 'doctor'])->orderBy('appointment_date')->get()
        ]);
    })->name('doctor.dashboard');

    // Interface Comptable
    Route::get('/accountant/dashboard', function () {
        if (!in_array(Auth::user()->role, ['accountant', 'superadmin'])) { abort(403); }
        return view('accountant.dashboard', [
            'payments' => \App\Models\Payment::with('patient')->orderBy('created_at', 'desc')->get(),
            'totalRevenue' => \App\Models\Payment::where('status', 'paid')->sum('amount'),
            'pendingRevenue' => \App\Models\Payment::where('status', 'pending')->sum('amount'),
        ]);
    })->name('accountant.dashboard');

    // Système d'invitations (Réservé aux admins)
    Route::get('/admin/invitations', [\App\Http\Controllers\Admin\InvitationController::class, 'index'])->name('admin.invitations.index');
    Route::post('/admin/invitations', [\App\Http\Controllers\Admin\InvitationController::class, 'store'])->name('admin.invitations.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
