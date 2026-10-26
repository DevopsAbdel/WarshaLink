<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LigneAchat extends Model
{
    protected $table = 'lignes_achat';

    protected $fillable = [
        'demande_achat_id',
        'article_id',
        'designation',
        'unite',
        'quantite_demandee',
        'quantite_commandee',
        'quantite_recue',
        'prix_unitaire_estime',
        'prix_unitaire_negocie_ht',
        'remarques',
    ];

    protected $casts = [
        'quantite_demandee' => 'decimal:2',
        'quantite_commandee' => 'decimal:2',
        'quantite_recue' => 'decimal:2',
        'prix_unitaire_estime' => 'decimal:2',
        'prix_unitaire_negocie_ht' => 'decimal:2',
    ];

    public function demandeAchat(): BelongsTo
    {
        return $this->belongsTo(DemandeAchat::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(ArticleCatalogue::class, 'article_id');
    }

    public function lignesReception(): HasMany
    {
        return $this->hasMany(LigneReception::class, 'ligne_achat_id');
    }
}
