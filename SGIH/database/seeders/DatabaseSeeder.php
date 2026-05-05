<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Directeur Général / Propriétaire de l'établissement
        User::create([
            'name' => 'Direction Générale',
            'email' => 'direction@sgih.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        // Comptable / Finance
        User::create([
            'name' => 'Service Comptabilité',
            'email' => 'compta@sgih.com',
            'password' => Hash::make('password'),
            'role' => 'accountant',
        ]);

        // Réceptionniste (Gère les patients)
        User::create([
            'name' => 'Réception Accueil',
            'email' => 'reception@sgih.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Compte Médecin pour la démo
        User::create([
            'name' => 'Dr. Mohamed Diarra',
            'email' => 'medecin@sgih.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        // Médecins Maliens
        $doctor1 = Doctor::create([
            'last_name' => 'Diarra',
            'first_name' => 'Mohamed',
            'specialty' => 'Cardiologue',
            'phone' => '+223 70 00 00 01',
            'email' => 'm.diarra@hospicare.ml',
        ]);

        $doctor2 = Doctor::create([
            'last_name' => 'Traoré',
            'first_name' => 'Aminata',
            'specialty' => 'Gynécologue',
            'phone' => '+223 60 00 00 02',
            'email' => 'a.traore@hospicare.ml',
        ]);

        Doctor::create([
            'last_name' => 'Sidibé',
            'first_name' => 'Oumar',
            'specialty' => 'Pédiatre',
            'phone' => '+223 70 00 00 03',
            'email' => 'o.sidibe@hospicare.ml',
        ]);

        // Patients Maliens
        $patients = [
            ['last_name' => 'Sissoko', 'first_name' => 'Mariam', 'birth_date' => '1992-04-12', 'gender' => 'Féminin', 'phone' => '+223 76 12 34 56', 'address' => 'Sébénikoro, Bamako', 'status' => 'Actif'],
            ['last_name' => 'Doumbia', 'first_name' => 'Adama', 'birth_date' => '1985-08-25', 'gender' => 'Masculin', 'phone' => '+223 66 23 45 67', 'address' => 'Hippodrome, Bamako', 'status' => 'En attente'],
            ['last_name' => 'Keita', 'first_name' => 'Awa', 'birth_date' => '1998-11-02', 'gender' => 'Féminin', 'phone' => '+223 74 34 56 78', 'address' => 'Missabougou, Bamako', 'status' => 'Actif'],
            ['last_name' => 'Coulibaly', 'first_name' => 'Moussa', 'birth_date' => '1970-01-30', 'gender' => 'Masculin', 'phone' => '+223 65 45 67 89', 'address' => 'Badalabougou, Bamako', 'status' => 'Actif'],
            ['last_name' => 'Maiga', 'first_name' => 'Fanta', 'birth_date' => '2005-06-18', 'gender' => 'Féminin', 'phone' => '+223 72 56 78 90', 'address' => 'Kalaban Coro, Bamako', 'status' => 'En attente'],
        ];

        foreach ($patients as $pData) {
            $p = Patient::create($pData);
            
            // Paiement fictif
            \App\Models\Payment::create([
                'patient_id' => $p->id,
                'amount' => rand(10000, 50000),
                'description' => 'Frais Médicaux - ' . ($p->status === 'Actif' ? 'Consultation' : 'Examen'),
                'status' => $p->status === 'Actif' ? 'paid' : 'pending'
            ]);

            // Un RDV pour le premier patient
            if ($pData['last_name'] === 'Sissoko') {
                Appointment::create([
                    'patient_id' => $p->id,
                    'doctor_id' => $doctor1->id,
                    'appointment_date' => now()->addDays(1),
                    'status' => 'confirmed',
                    'reason' => 'Suivi tension artérielle',
                ]);
            }
        }
    }
}
