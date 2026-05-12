<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'total_employees' => Employee::count(),
            'appointments_today' => Appointment::whereDate('date_rdv', now())->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}