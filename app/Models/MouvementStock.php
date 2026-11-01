<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MouvementStock extends Model
{
    use HasFactory;

    protected $table = 'mouvements_stock';

    protected $fillable = [
        'numero_mouvement',
        'type_mouvement',
        'article_id',
        'chantier_source_id',
        'chantier_destination_id',
        'quantite',
        'quantite_avant',
        'quantite_apres',
        'reception_bl_id',
        'auteur_id',
        'motif_usage',
        'lot_ouvrage',
        'date_mouvement',
    ];

    protected $casts = [
        'quantite' => 'decimal:2',
        'quantite_avant' => 'decimal:2',
        'quantite_apres' => 'decimal:2',
        'date_mouvement' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($mouvement) {
            if (empty($mouvement->numero_mouvement)) {
                $mouvement->numero_mouvement = 'MVT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
            }
            if (empty($mouvement->date_mouvement)) {
                $mouvement->date_mouvement = now();
            }
        });
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(ArticleCatalogue::class, 'article_id');
    }

    public function chantierSource(): BelongsTo
    {
        return $this->belongsTo(Chantier::class, 'chantier_source_id');
    }

    public function chantierDestination(): BelongsTo
    {
        return $this->belongsTo(Chantier::class, 'chantier_destination_id');
    }

    public function receptionBl(): BelongsTo
    {
        return $this->belongsTo(ReceptionBl::class, 'reception_bl_id');
    }

    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auteur_id');
    }
}
