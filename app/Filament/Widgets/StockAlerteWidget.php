<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\DemandeAchatResource;
use App\Models\Stock;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class StockAlerteWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Stock::query()
                    ->with(['chantier', 'article'])
                    ->whereColumn('quantite_actuelle', '<=', 'seuil_alerte_min')
                    ->orderBy('quantite_actuelle', 'asc')
                    ->limit(5)
            )
            ->heading('⚠️ Alertes Stocks & Ruptures Critiques sur Chantiers')
            ->description('Matériaux sous le seuil d\'alerte nécessitant un réapprovisionnement rapide.')
            ->columns([
                Tables\Columns\TextColumn::make('chantier.nom')
                    ->label('Chantier Concerné')
                    ->badge()
                    ->color('info')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('article.designation')
                    ->label('Matériau en Rupture / Alerte')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('article.categorie')
                    ->label('Catégorie')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('quantite_actuelle')
                    ->label('Stock Restant')
                    ->formatStateUsing(fn ($state, Stock $record) => number_format((float) $state, 2, ',', ' ') . ' ' . ($record->article?->unite ?? 'U'))
                    ->color('danger')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('seuil_alerte_min')
                    ->label('Seuil Min')
                    ->formatStateUsing(fn ($state, Stock $record) => number_format((float) $state, 2, ',', ' ') . ' ' . ($record->article?->unite ?? 'U')),

                Tables\Columns\TextColumn::make('emplacement')
                    ->label('Emplacement')
                    ->placeholder('—'),
            ])
            ->actions([
                Tables\Actions\Action::make('commander')
                    ->label('Créer DA')
                    ->icon('heroicon-o-shopping-cart')
                    ->color('danger')
                    ->url(fn () => DemandeAchatResource::getUrl('create')),
            ]);
    }
}
