<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AccountantController extends Controller
{
    public function dashboard()
    {
        return view('accountant.dashboard', [
            'payments' => Payment::with('patient')->orderBy('created_at', 'desc')->get(),
            'totalRevenue' => Payment::where('status', 'paid')->sum('amount'),
            'pendingRevenue' => Payment::where('status', 'pending')->sum('amount'),
        ]);
    }

    public function markAsPaid(Payment $payment)
    {
        $payment->update(['status' => 'paid']);

        return redirect()->back()->with(
            'success',
            'Le paiement de ' . number_format($payment->amount, 0, ',', ' ') . ' F a été encaissé avec succès.'
        );
    }
}
