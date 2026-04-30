<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consultation extends Model
{
    protected $fillable = ['patient_id', 'medecin_id', 'date_consultation', 'tarif', 'notes_medicales', 'statut_paiement'];

    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
    public function medecin(): BelongsTo { return $this->belongsTo(Medecin::class); }
}