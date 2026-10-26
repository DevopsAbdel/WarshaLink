<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fournisseur extends Model
{
    protected $fillable = [
        'nom',
        'ice',
        'ville',
        'adresse',
        'telephone',
        'email',
        'contact_nom',
        'rib',
    ];

    public function bonsCommande(): HasMany
    {
        return $this->hasMany(BonCommande::class);
    }
}
