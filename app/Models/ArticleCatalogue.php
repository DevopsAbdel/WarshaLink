<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleCatalogue extends Model
{
    protected $table = 'articles_catalogue';

    protected $fillable = [
        'code',
        'designation',
        'categorie',
        'unite',
        'prix_indicatif_ht',
    ];

    protected $casts = [
        'prix_indicatif_ht' => 'decimal:2',
    ];

    public function lignesAchat(): HasMany
    {
        return $this->hasMany(LigneAchat::class, 'article_id');
    }
}
