<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneReception extends Model
{
    protected $table = 'lignes_reception';

    protected $fillable = [
        'reception_bl_id',
        'ligne_achat_id',
        'quantite_recue',
        'conforme',
        'motif_ecart',
    ];

    protected $casts = [
        'quantite_recue' => 'decimal:2',
        'conforme' => 'boolean',
    ];

    public function receptionBl(): BelongsTo
    {
        return $this->belongsTo(ReceptionBl::class);
    }

    public function ligneAchat(): BelongsTo
    {
        return $this->belongsTo(LigneAchat::class);
    }
}
