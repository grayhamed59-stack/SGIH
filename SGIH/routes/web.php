<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\AccountantController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// --- Public Home ---
Route::get('/', function () {
    return view('welcome');
});

// --- Shared Dashboard (fallback) ---
Route::get('/dashboard', function () {
    return view('dashboard', [
        'patientsCount'    => \App\Models\Patient::count(),
        'doctorsCount'     => \App\Models\Doctor::count(),
        'appointmentsCount'=> \App\Models\Appointment::count(),
        'recentPatients'   => \App\Models\Patient::orderBy('created_at', 'desc')->take(5)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// =========================================================
//  All authenticated routes
// =========================================================
Route::middleware('auth')->group(function () {

    // --- Profile ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---- SuperAdmin / Direction ----
    Route::middleware('role:superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('superadmin.dashboard', [
                'patientsCount'     => \App\Models\Patient::count(),
                'doctorsCount'      => \App\Models\Doctor::count(),
                'appointmentsCount' => \App\Models\Appointment::count(),
                'revenue'           => \App\Models\Payment::where('status', 'paid')
                                          ->whereDate('created_at', \Illuminate\Support\Carbon::today())
                                          ->sum('amount'),
                'totalRevenue'      => \App\Models\Payment::where('status', 'paid')->sum('amount'),
                'cancellationsCount'=> \App\Models\Appointment::where('status', 'cancelled')->count(),
            ]);
        })->name('dashboard');
    });

    // ---- Médecin ----
    Route::middleware('role:doctor')->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', function () {
            return view('doctor.dashboard', [
                'appointmentsList' => \App\Models\Appointment::with(['patient', 'doctor'])
                                        ->orderBy('appointment_date')->get(),
            ]);
        })->name('dashboard');
    });

    // ---- Comptable ----
    Route::middleware('role:accountant')->prefix('accountant')->name('accountant.')->group(function () {
        Route::get('/dashboard', [AccountantController::class, 'dashboard'])->name('dashboard');
        Route::put('/payments/{payment}/paid', [AccountantController::class, 'markAsPaid'])->name('payments.paid');
    });

    // ---- Réceptionniste ----
    Route::middleware('role:receptionist')->prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', [ReceptionistController::class, 'dashboard'])->name('dashboard');
    });

    // ---- Gestion Patients (réceptionniste + superadmin) ----
    Route::middleware('role:receptionist,superadmin,admin')->group(function () {
        Route::get('/patients/export', [PatientController::class, 'export'])->name('patients.export');
        Route::resource('patients', PatientController::class);
    });

    // ---- Rendez-vous (médecin + réceptionniste + superadmin) ----
    Route::put('/appointments/{appointment}/cancel', [\App\Http\Controllers\AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');

    // ---- Gestion Invitations + OTP (superadmin uniquement) ----
    Route::middleware('role:superadmin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/invitations', [\App\Http\Controllers\Admin\InvitationController::class, 'index'])->name('invitations.index');
        Route::post('/invitations', [\App\Http\Controllers\Admin\InvitationController::class, 'store'])->name('invitations.store');
    });
});

require __DIR__.'/auth.php';
