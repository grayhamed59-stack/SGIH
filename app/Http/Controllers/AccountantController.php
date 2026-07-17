<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Payment;
use App\Models\Expense;
use Illuminate\Http\Request;

class AccountantController extends Controller
{
    public function dashboard()
    {
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        $pendingRevenue = Payment::where('status', 'pending')->sum('amount');
        $totalExpenses = Expense::sum('amount');
        $netProfit = $totalRevenue - $totalExpenses;

        return view('accountant.dashboard', [
            'payments'       => Payment::with('patient')->orderBy('created_at', 'desc')->get(),
            'expenses'       => Expense::orderBy('expense_date', 'desc')->get(),
            'totalRevenue'   => $totalRevenue,
            'pendingRevenue' => $pendingRevenue,
            'totalExpenses'  => $totalExpenses,
            'netProfit'      => $netProfit,
        ]);
    }

    public function createPayment()
    {
        $patients = Patient::orderBy('last_name')->get();
        return view('accountant.payments.create', compact('patients'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'patient_id'  => 'required|exists:patients,id',
            'amount'      => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
            'status'      => 'required|in:paid,pending',
        ]);

        Payment::create([
            'patient_id'  => $request->patient_id,
            'amount'      => $request->amount,
            'description' => $request->description,
            'status'      => $request->status,
        ]);

        return redirect()->route('accountant.dashboard')
            ->with('success', 'Facture enregistrée avec succès.');
    }

    public function markAsPaid(Payment $payment)
    {
        $payment->update(['status' => 'paid']);

        // Si le paiement est lié à un rendez-vous, on confirme le rendez-vous
        if ($payment->appointment_id) {
            $appointment = \App\Models\Appointment::find($payment->appointment_id);
            if ($appointment) {
                $appointment->update(['status' => 'confirmed']);
            }
        }

        // Notifier les superadmins
        $superadmins = \App\Models\User::where('role', 'superadmin')->get();
        \Illuminate\Support\Facades\Notification::send($superadmins, new \App\Notifications\PaymentConfirmedNotification($payment));

        return redirect()->back()->with(
            'success',
            'Le paiement de ' . number_format($payment->amount, 0, ',', ' ') . ' F a été encaissé avec succès.'
        );
    }

    public function showReceipt(Payment $payment)
    {
        $payment->load(['patient', 'appointment.doctor']);
        return view('accountant.receipt', compact('payment'));
    }

    public function createExpense()
    {
        return view('accountant.expenses.create');
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'category'     => 'required|string|max:100',
            'description'  => 'required|string|max:255',
            'amount'       => 'required|numeric|min:1',
            'expense_date' => 'required|date',
            'reference'    => 'nullable|string|max:100',
        ]);

        Expense::create($validated);

        return redirect()->route('accountant.dashboard')
            ->with('success', 'La dépense de ' . number_format($validated['amount'], 0, ',', ' ') . ' F a été enregistrée avec succès.');
    }
}
