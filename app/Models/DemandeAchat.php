<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DemandeAchat extends Model
{
    protected $table = 'demandes_achat';

    protected $fillable = [
        'chantier_id',
        'demandeur_id',
        'numero_da',
        'urgence',
        'statut',
        'motif',
        'date_besoin',
        'justificatif_photo_path',
        'montant_estime_total_ht',
        'conducteur_valideur_id',
        'date_validation_conducteur',
        'dg_valideur_id',
        'date_validation_dg',
        'motif_rejet',
    ];

    protected $casts = [
        'date_besoin' => 'date',
        'date_validation_conducteur' => 'datetime',
        'date_validation_dg' => 'datetime',
        'montant_estime_total_ht' => 'decimal:2',
    ];

    public function chantier(): BelongsTo
    {
        return $this->belongsTo(Chantier::class);
    }

    public function demandeur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'demandeur_id');
    }

    public function conducteurValideur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'conducteur_valideur_id');
    }

    public function dgValideur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dg_valideur_id');
    }

    public function lignesAchat(): HasMany
    {
        return $this->hasMany(LigneAchat::class, 'demande_achat_id');
    }

    public function bonCommande(): HasOne
    {
        return $this->hasOne(BonCommande::class, 'demande_achat_id');
    }
}
