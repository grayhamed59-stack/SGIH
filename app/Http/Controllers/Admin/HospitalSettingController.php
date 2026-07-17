<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HospitalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HospitalSettingController extends Controller
{
    /**
     * Affiche le formulaire de configuration de l'établissement.
     */
    public function edit()
    {
        // On s'assure de récupérer la configuration existante ou d'en créer une par défaut.
        $setting = HospitalSetting::current();
        
        return view('admin.settings.hospital', compact('setting'));
    }

    /**
     * Met à jour la configuration de l'établissement.
     */
    public function update(Request $request)
    {
        $setting = HospitalSetting::current();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo si ce n'est pas celui par défaut
            if ($setting->logo_path && Storage::disk('public')->exists($setting->logo_path)) {
                Storage::disk('public')->delete($setting->logo_path);
            }
            
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo_path'] = $path;
        }

        $setting->update($validated);

        return redirect()->back()->with('success', "Identité de l'établissement mise à jour avec succès.");
    }
}
