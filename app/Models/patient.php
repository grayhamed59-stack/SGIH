<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = ['nom', 'prenom', 'date_naissance', 'genre', 'telephone', 'adresse', 'groupe_sanguin'];

    public function hospitalisations(): HasMany
    {
        return $this->hasMany(Hospitalisation::class);
    }

    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }

}