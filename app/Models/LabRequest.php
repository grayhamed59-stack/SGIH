<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
    protected $fillable = ['patient_id', 'test_type', 'notes', 'status'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
