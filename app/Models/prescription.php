<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    // Autoriser le remplissage de ces champs via un formulaire
    protected $fillable = [
        'patient_id',
        'medecin_id',
        'medicaments',
        'instructions',
        'date_prescription'
    ];

    /**
     * Récupérer le patient à qui appartient cette prescription.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Récupérer le médecin qui a rédigé cette prescription.
     */
    public function medecin(): BelongsTo
    {
        return $this->belongsTo(Medecin::class);
    }
    protected $casts = [
    'medicaments' => 'array',
    'date_prescription' => 'date',
    ];
}