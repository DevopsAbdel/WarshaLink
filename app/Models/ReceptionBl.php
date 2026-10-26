<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReceptionBl extends Model
{
    protected $table = 'receptions_bl';

    protected $fillable = [
        'bon_commande_id',
        'chantier_id',
        'receptionnaire_id',
        'numero_bl_fournisseur',
        'date_reception',
        'photo_bl_path',
        'statut_conformite',
        'observations',
    ];

    protected $casts = [
        'date_reception' => 'datetime',
    ];

    public function bonCommande(): BelongsTo
    {
        return $this->belongsTo(BonCommande::class);
    }

    public function chantier(): BelongsTo
    {
        return $this->belongsTo(Chantier::class);
    }

    public function receptionnaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receptionnaire_id');
    }

    public function lignesReception(): HasMany
    {
        return $this->hasMany(LigneReception::class, 'reception_bl_id');
    }
}
