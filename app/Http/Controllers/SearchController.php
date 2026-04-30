<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;


class SearchController extends Controller
{
    
        public function query(Request $request)
        {
            $q = $request->input('q');

            // Recherche par nom, prénom ou téléphone
            $results = Patient::where('nom', 'LIKE', "%{$q}%")
                ->orWhere('prenom', 'LIKE', "%{$q}%")
                ->orWhere('telephone', 'LIKE', "%{$q}%")
                ->get();

            return view('search.results', compact('results', 'q'));
        }
    
}
