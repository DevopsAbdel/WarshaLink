<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employe extends Model
{
    protected $fillable = [
        'matricule',
        'cin',
        'nom',
        'prenom',
        'telephone',
        'specialite',
        'type_contrat',
        'cout_journalier_mad',
        'chantier_actuel_id',
        'is_actif',
    ];

    protected $casts = [
        'cout_journalier_mad' => 'decimal:2',
        'is_actif' => 'boolean',
    ];

    public function getNomCompletAttribute(): string
    {
        return "{$this->nom} {$this->prenom}";
    }

    public function chantierActuel(): BelongsTo
    {
        return $this->belongsTo(Chantier::class, 'chantier_actuel_id');
    }

    public function pointages(): HasMany
    {
        return $this->hasMany(Pointage::class);
    }
}
