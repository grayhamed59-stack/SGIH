<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalSetting extends Model
{
    protected $fillable = [
        'name',
        'logo_path',
        'address',
        'phone',
        'email',
        'primary_color',
    ];

    /**
     * Helper pour toujours récupérer la configuration actuelle (V1 SaaS).
     * S'il n'y en a pas, on en crée une par défaut.
     */
    public static function current()
    {
        $setting = self::first();
        
        if (!$setting) {
            $setting = self::create([
                'name' => 'CHU Point G',
                'address' => 'Bamako, Mali',
                'phone' => '+223 00 00 00 00',
                'email' => 'contact@chupointg.ml',
            ]);
        }
        
        return $setting;
    }
}
