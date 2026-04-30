<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Chambre;
use App\Models\Medecin;
use App\Models\Facture;
use App\Models\Hospitalisation;


class DashboardController extends Controller
{

    
        public function index()
        {
            // Statistiques simples
            $totalPatients = Patient::count();
            $totalMedecins = Medecin::count();
        
            // Chambres
            $chambresOccupees = Chambre::where('est_occupee', true)->count();
            $totalChambres = Chambre::count();
        
            // Calcul financier (Somme des factures payées ou totales)
            $revenusTotal = Facture::sum('montant_total');

            // Dernières hospitalisations pour le tableau
            $dernieresHosp = Hospitalisation::with(['patient', 'chambre'])
                        ->latest()
                        ->take(5)
                        ->get();

            return view('dashboard', compact(
                'totalPatients',
                'totalMedecins',
                'chambresOccupees',
                'totalChambres',
                'revenusTotal',
                'dernieresHosp'
        ));
    }
}

