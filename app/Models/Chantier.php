<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chantier extends Model
{
    protected $fillable = [
        'ville_id',
        'code',
        'nom',
        'client',
        'adresse',
        'latitude',
        'longitude',
        'rayon_metres',
        'budget_total',
        'date_debut',
        'date_fin_prevue',
        'statut',
    ];

    protected $casts = [
        'budget_total' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'rayon_metres' => 'integer',
        'date_debut' => 'date',
        'date_fin_prevue' => 'date',
    ];

    public function ville(): BelongsTo
    {
        return $this->belongsTo(Ville::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chantier_user')
            ->withPivot('role_sur_chantier')
            ->withTimestamps();
    }

    public function employes(): HasMany
    {
        return $this->hasMany(Employe::class, 'chantier_actuel_id');
    }

    public function demandesAchat(): HasMany
    {
        return $this->hasMany(DemandeAchat::class);
    }

    public function pointages(): HasMany
    {
        return $this->hasMany(Pointage::class);
    }

    public function receptionsBl(): HasMany
    {
        return $this->hasMany(ReceptionBl::class);
    }
}
