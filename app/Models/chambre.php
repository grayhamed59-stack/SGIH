<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chambre extends Model
{
    protected $fillable = ['numero_chambre', 'type', 'prix_journalier', 'est_occupee'];

    public function hospitalisations(): HasMany
    {
        return $this->hasMany(Hospitalisation::class);
    }
}