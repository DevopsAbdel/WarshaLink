<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';

    protected $fillable = [
        'chantier_id',
        'article_id',
        'quantite_actuelle',
        'seuil_alerte_min',
        'emplacement',
        'derniere_entree_at',
        'derniere_sortie_at',
    ];

    protected $casts = [
        'quantite_actuelle' => 'decimal:2',
        'seuil_alerte_min' => 'decimal:2',
        'derniere_entree_at' => 'datetime',
        'derniere_sortie_at' => 'datetime',
    ];

    public function chantier(): BelongsTo
    {
        return $this->belongsTo(Chantier::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(ArticleCatalogue::class, 'article_id');
    }

    public function isEnAlerte(): bool
    {
        return $this->quantite_actuelle <= $this->seuil_alerte_min;
    }

    public function getValeurEstimeeAttribute(): float
    {
        $prixUnitaire = (float) ($this->article?->prix_unitaire_estime ?? 0);
        return (float) $this->quantite_actuelle * $prixUnitaire;
    }
}
