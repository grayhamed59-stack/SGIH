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
        'recentPatients'   => \App\Models\Patient::orderBy('created_at', 'desc')->paginate(5),
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

    // ---- Notifications ----
    Route::get('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

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
                // Seuls les RDV dont le paiement a été confirmé (status = 'confirmed') sont affichés.
                // Cela garantit que le médecin ne voit que des patients qui ont réglé leur consultation.
                'appointmentsList' => \App\Models\Appointment::with(['patient', 'doctor'])
                                        ->where('status', 'confirmed')
                                        ->orderBy('appointment_date')
                                        ->get(),
            ]);
        })->name('dashboard');
    });

    // ---- Comptable ----
    Route::middleware('role:accountant,superadmin')->prefix('accountant')->name('accountant.')->group(function () {
        Route::get('/dashboard', [AccountantController::class, 'dashboard'])->name('dashboard');
        Route::put('/payments/{payment}/paid', [AccountantController::class, 'markAsPaid'])->name('payments.paid');
        Route::get('/payments/{payment}/receipt', [AccountantController::class, 'showReceipt'])->name('payments.receipt');
        Route::get('/payments/create', [AccountantController::class, 'createPayment'])->name('payments.create');
        Route::post('/payments', [AccountantController::class, 'storePayment'])->name('payments.store');
        Route::get('/expenses/create', [AccountantController::class, 'createExpense'])->name('expenses.create');
        Route::post('/expenses', [AccountantController::class, 'storeExpense'])->name('expenses.store');
    });

    // ---- Réceptionniste ----
    Route::middleware('role:receptionist')->prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', [ReceptionistController::class, 'dashboard'])->name('dashboard');
    });

    // ---- Gestion Patients (réceptionniste + superadmin) ----
    Route::middleware('role:receptionist,superadmin')->group(function () {
        Route::get('/patients/export', [PatientController::class, 'export'])->name('patients.export');
        Route::post('/patients/lab', [PatientController::class, 'storeLabRequest'])->name('patients.lab.store');
        Route::post('/patients/admit', [PatientController::class, 'storeAdmission'])->name('patients.admit.store');
        Route::post('/patients/appointment', [PatientController::class, 'storeAppointment'])->name('patients.appointment.store');
        Route::resource('patients', PatientController::class);
    });

    // ---- Rendez-vous (médecin + réceptionniste + superadmin) ----
    Route::middleware('role:doctor,receptionist,superadmin')->group(function () {
        Route::put('/appointments/{appointment}/cancel', [\App\Http\Controllers\AppointmentController::class, 'cancel'])
            ->name('appointments.cancel');
        Route::get('/appointments/{appointment}/consultation', [\App\Http\Controllers\AppointmentController::class, 'startConsultation'])
            ->name('appointments.consultation.start');
        Route::post('/appointments/{appointment}/consultation', [\App\Http\Controllers\AppointmentController::class, 'storeConsultation'])
            ->name('appointments.consultation.store');
    });

    // ---- Gestion Invitations + OTP + Settings (superadmin uniquement) ----
    Route::middleware('role:superadmin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/invitations', [\App\Http\Controllers\Admin\InvitationController::class, 'index'])->name('invitations.index');
        Route::post('/invitations', [\App\Http\Controllers\Admin\InvitationController::class, 'store'])->name('invitations.store');
        Route::delete('/invitations/{invitation}', [\App\Http\Controllers\Admin\InvitationController::class, 'destroy'])->name('invitations.destroy');

        Route::get('/settings/hospital', [\App\Http\Controllers\Admin\HospitalSettingController::class, 'edit'])->name('settings.hospital');
        Route::post('/settings/hospital', [\App\Http\Controllers\Admin\HospitalSettingController::class, 'update'])->name('settings.hospital.update');
    });
});

require __DIR__.'/auth.php';
