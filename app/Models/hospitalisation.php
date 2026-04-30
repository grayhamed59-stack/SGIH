<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hospitalisation extends Model
{
    protected $fillable = ['patient_id', 'chambre_id', 'date_entree', 'date_sortie', 'motif_admission', 'frais_avance', 'statut'];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function chambre(): BelongsTo
    {
        return $this->belongsTo(Chambre::class);
    }

    // app/Models/Hospitalisation.php
    public function facture() { return $this->hasOne(Facture::class); }
}

