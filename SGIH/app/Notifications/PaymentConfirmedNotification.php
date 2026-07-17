<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Fired when an accountant confirms a payment.
 * Notifies: all superadmins (financial oversight).
 */
class PaymentConfirmedNotification extends Notification
{
    use Queueable;

    public function __construct(public Payment $payment) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $patient = $this->payment->patient;
        $amount  = number_format($this->payment->amount, 0, ',', ' ');

        return [
            'icon'    => 'banknote',
            'color'   => 'emerald',
            'title'   => 'Paiement Confirmé',
            'message' => "Paiement de {$amount} F encaissé pour {$patient->first_name} {$patient->last_name}.",
            'url'     => route('accountant.dashboard'),
        ];
    }
}
