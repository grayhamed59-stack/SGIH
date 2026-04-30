<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospitalisation;
use App\Models\Patient;
use App\Models\Chambre;
use App\Models\Facture;
use Carbon\Carbon;

class hospitalisationController extends Controller
{
        public function show($id)
    {
        // C'est ici que vous placez votre code
        $hospitalisation = Hospitalisation::find($id);

        if ($hospitalisation) {
            return view('hospitalisations.details', [
                'numero' => $hospitalisation->chambre->numero_chambre
            ]);
        }
            else {
                return redirect()->back()->with('error', 'Hospitalisation non trouvée.');
            }
        $patient = Patient::find(1);
        foreach ($patient->hospitalisations as $hosp) {
            echo $hosp->date_entree;
        }
        $patient = Patient::with('prescriptions')->find(1);
    }
    public function create()
    {
        $patients = Patient::all();

        $chambres = Chambre::where('est_occupee', false)->get();
        
        return view('hospitalisations.create', compact('patients', 'chambres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'chambre_id' => 'required|exists:chambres,id',
            'date_entree' => 'required|date',
            'motif_admission' => 'nullable|string',
        ]);

        Hospitalisation::create($request->all());

        $chambre = Chambre::find($request->chambre_id);
        $chambre->update(['est_occupee' => true]);

        return redirect()->route('hospitalisations.index')->with('success', 'Le patient a été installé dans sa chambre.');
    }
    public function sortir($id)
    {
        $hospitalisation = Hospitalisation::findOrFail($id);

        $hospitalisation->update([
            'date_sortie' => now(),
            'statut' => 'terminé'
        ]);

        $hospitalisation->chambre->update(['est_occupee' => false]);

        return redirect()->back()->with('success', 'Le patient a été libéré et la chambre est à nouveau disponible.');
        $hosp = Hospitalisation::with('chambre')->findOrFail($id);

    // 1. Enregistrer la sortie
    $hosp->update([
        'date_sortie' => now(),
        'statut' => 'terminé'
    ]);

    // 2. Libérer la chambre
    $hosp->chambre->update(['est_occupee' => false]);

    // 3. CALCUL DE LA FACTURE
    $entree = Carbon::parse($hosp->date_entree);
    $sortie = Carbon::parse($hosp->date_sortie);
    
    // Calcul du nombre de jours (minimum 1 jour)
    $nbJours = $entree->diffInDays($sortie);
    if ($nbJours == 0) $nbJours = 1;

    $montantChambre = $nbJours * $hosp->chambre->prix_journalier;

    // 4. Créer la facture
    Facture::create([
        'hospitalisation_id' => $hosp->id,
        'montant_chambre' => $montantChambre,
        // On déduit l'avance
        'montant_total' => $montantChambre - $hosp->frais_avance,
    ]);

    return redirect()->back()->with('success', 'Patient libéré et facture générée !');


    }
}