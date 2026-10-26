<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BonCommande extends Model
{
    protected $table = 'bons_commande';

    protected $fillable = [
        'demande_achat_id',
        'fournisseur_id',
        'cree_par_id',
        'numero_bc',
        'date_commande',
        'delai_livraison_prevu',
        'conditions_paiement',
        'montant_total_ht',
        'taux_tva',
        'montant_tva',
        'montant_total_ttc',
        'statut',
        'pdf_path',
    ];

    protected $casts = [
        'date_commande' => 'date',
        'delai_livraison_prevu' => 'date',
        'montant_total_ht' => 'decimal:2',
        'taux_tva' => 'decimal:2',
        'montant_tva' => 'decimal:2',
        'montant_total_ttc' => 'decimal:2',
    ];

    public function demandeAchat(): BelongsTo
    {
        return $this->belongsTo(DemandeAchat::class);
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function creePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cree_par_id');
    }

    public function receptionsBl(): HasMany
    {
        return $this->hasMany(ReceptionBl::class);
    }
}
