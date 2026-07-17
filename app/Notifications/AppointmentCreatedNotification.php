<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

/**
 * Fired when a receptionist creates a new appointment.
 * Notifies: the assigned doctor + all superadmins.
 */
class AppointmentCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $patient = $this->appointment->patient;
        $doctor  = $this->appointment->doctor;

        return [
            'icon'    => 'calendar-plus',
            'color'   => 'blue',
            'title'   => 'Nouveau Rendez-vous',
            'message' => "RDV créé pour {$patient->first_name} {$patient->last_name} — Dr. " .
                         ($doctor ? $doctor->first_name . ' ' . $doctor->last_name : 'N/A') .
                         " le " . \Carbon\Carbon::parse($this->appointment->appointment_date)->format('d/m/Y à H:i'),
            'url'     => route('patients.index'),
        ];
    }
}
