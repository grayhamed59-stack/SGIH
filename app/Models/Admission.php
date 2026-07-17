<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = ['patient_id', 'room_number', 'reason', 'status'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
