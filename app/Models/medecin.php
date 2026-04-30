<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medecin extends Model
{
    // Indique les champs qui peuvent être remplis via un formulaire (Mass Assignment)
    protected $fillable = [
        'nom',
        'prenom',
        'specialite',
        'email',
        'telephone'
    ];

    /**
     * Un médecin peut rédiger plusieurs prescriptions.
     */
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }
}

