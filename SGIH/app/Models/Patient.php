<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'last_name',
        'first_name',
        'birth_date',
        'gender',
        'phone',
        'address',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
