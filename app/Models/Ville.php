<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ville extends Model
{
    protected $fillable = [
        'nom',
        'region',
        'code_postal',
    ];

    public function chantiers(): HasMany
    {
        return $this->hasMany(Chantier::class);
    }
}
