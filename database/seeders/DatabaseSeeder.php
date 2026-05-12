<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin SGIH',
            'email' => 'admin@sgih.com',
            'password' => Hash::make('password'),
        ]);

        // Au lieu de User::create([...])
        \App\Models\User::updateOrCreate(
        ['email' => 'admin@sgih.com'], // Condition de recherche
        [
            'name' => 'Admin SGIH',
            'password' => bcrypt('password'),
        ]
);

        \App\Models\Patient::factory(50)->create();
        \App\Models\Employee::factory(15)->create();
        // On crée aussi quelques RDV pour aujourd'hui
        \App\Models\Appointment::create([
            'patient_id' => 1,
            'medecin_id' => 1,
            'date_rdv' => now(),
            'heure_debut' => '09:00',
            'heure_fin' => '10:00',
            'statut' => 'en_attente'
        ]);

        // Sample Doctors
        $doctor = Doctor::create([
            'last_name' => 'Koffi',
            'first_name' => 'Jean',
            'specialty' => 'Cardiologue',
            'phone' => '0102030405',
            'email' => 'koffi@hospital.com',
        ]);

        Doctor::create([
            'last_name' => 'Traoré',
            'first_name' => 'Aminata',
            'specialty' => 'Pédiatre',
            'phone' => '0203040506',
            'email' => 'traore@hospital.com',
        ]);

        // Sample Patients
        $patient = Patient::create([
            'last_name' => 'Diallo',
            'first_name' => 'Moussa',
            'birth_date' => '1990-05-15',
            'gender' => 'Masculin',
            'phone' => '0708091011',
            'address' => 'Abidjan, Cocody',
        ]);

        Patient::create([
            'last_name' => 'Koné',
            'first_name' => 'Fatoumata',
            'birth_date' => '1985-11-22',
            'gender' => 'Féminin',
            'phone' => '0506070809',
            'address' => 'Bouaké',
        ]);

        // Sample Appointment
        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'appointment_date' => now()->addDays(2),
            'status' => 'confirmed',
            'reason' => 'Consultation de routine cardiologie',
        ]);
    }
}
