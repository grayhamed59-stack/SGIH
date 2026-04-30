<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    protected $fillable = ['nom_commercial', 'forme', 'quantite_stock', 'prix_unitaire', 'date_expiration'];
}