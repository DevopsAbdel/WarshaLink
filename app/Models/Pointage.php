<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pointage extends Model
{
    protected $fillable = [
        'chantier_id',
        'employe_id',
        'pointeur_id',
        'date_pointage',
        'statut_presence',
        'heures_normales',
        'heures_sup',
        'latitude_pointage',
        'longitude_pointage',
        'is_geoloc_valide',
        'valide_par_conducteur_id',
        'date_validation_conducteur',
        'remarques',
    ];

    protected $casts = [
        'date_pointage' => 'date',
        'date_validation_conducteur' => 'datetime',
        'heures_normales' => 'decimal:1',
        'heures_sup' => 'decimal:1',
        'latitude_pointage' => 'decimal:7',
        'longitude_pointage' => 'decimal:7',
        'is_geoloc_valide' => 'boolean',
    ];

    public function chantier(): BelongsTo
    {
        return $this->belongsTo(Chantier::class);
    }

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    public function pointeur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pointeur_id');
    }

    public function conducteurValideur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'valide_par_conducteur_id');
    }
}
