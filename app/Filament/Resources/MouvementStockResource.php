<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MouvementStockResource\Pages;
use App\Models\MouvementStock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MouvementStockResource extends Resource
{
    protected static ?string $model = MouvementStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-up-down';

    protected static ?string $navigationGroup = '📦 Gestion des Stocks';

    protected static ?string $modelLabel = 'Mouvement de Stock';

    protected static ?string $pluralModelLabel = 'Journal des Mouvements';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('numero_mouvement')->disabled(),
                Forms\Components\TextInput::make('type_mouvement')->disabled(),
                Forms\Components\TextInput::make('quantite')->disabled(),
                Forms\Components\TextInput::make('motif_usage')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['article', 'chantierSource', 'chantierDestination', 'auteur']))
            ->columns([
                Tables\Columns\TextColumn::make('date_mouvement')
                    ->label('Date & Heure')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('numero_mouvement')
                    ->label('Réf Mouvement')
                    ->fontFamily('mono')
                    ->color('gray')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type_mouvement')
                    ->label('Type Flux')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'entree_livraison' => 'success',
                        'entree_retour_chantier' => 'info',
                        'sortie_consommation' => 'warning',
                        'sortie_perte_casse' => 'danger',
                        'transfert_inter_chantier' => 'primary',
                        'ajustement_inventaire' => 'gray',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'entree_livraison' => '📥 Entrée (BL Fournisseur)',
                        'entree_retour_chantier' => '↩️ Retour au Stock',
                        'sortie_consommation' => '📤 Sortie Chantier',
                        'sortie_perte_casse' => '❌ Perte / Casse',
                        'transfert_inter_chantier' => '🔄 Transfert Chantiers',
                        'ajustement_inventaire' => '⚖️ Ajustement Inventaire',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('article.designation')
                    ->label('Matériau')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantite')
                    ->label('Quantité Flux')
                    ->weight('bold')
                    ->formatStateUsing(fn ($state, MouvementStock $record) => number_format((float) $state, 2, ',', ' ') . ' ' . ($record->article?->unite ?? 'U'))
                    ->color(fn (MouvementStock $record): string => match (true) {
                        str_starts_with($record->type_mouvement, 'entree') => 'success',
                        str_starts_with($record->type_mouvement, 'sortie') => 'warning',
                        default => 'primary',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('chantier_source.nom')
                    ->label('De (Source)')
                    ->badge()
                    ->color('gray')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('chantier_destination.nom')
                    ->label('Vers (Destination)')
                    ->badge()
                    ->color('info')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('lot_ouvrage')
                    ->label('Lot / Zone')
                    ->placeholder('—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('motif_usage')
                    ->label('Motif / Justification')
                    ->limit(40)
                    ->tooltip(fn (MouvementStock $record): ?string => $record->motif_usage)
                    ->searchable(),

                Tables\Columns\TextColumn::make('auteur.name')
                    ->label('Opérateur')
                    ->color('gray')
                    ->toggleable(),
            ])
            ->defaultSort('date_mouvement', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type_mouvement')
                    ->label('Type de flux')
                    ->options([
                        'entree_livraison' => 'Entrée Livraison (BL)',
                        'sortie_consommation' => 'Sortie Consommation',
                        'transfert_inter_chantier' => 'Transfert Inter-Chantiers',
                        'ajustement_inventaire' => 'Ajustement Inventaire',
                        'sortie_perte_casse' => 'Perte / Casse',
                    ]),

                Tables\Filters\SelectFilter::make('article_id')
                    ->label('Filtrer par Matériau')
                    ->relationship('article', 'designation'),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMouvementsStock::route('/'),
        ];
    }
}
