<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Models\Chantier;
use App\Models\Stock;
use App\Services\StockService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = '📦 Gestion des Stocks';

    protected static ?string $modelLabel = 'Stock Matériaux';

    protected static ?string $pluralModelLabel = 'État des Stocks par Chantier';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Affectation Chantier & Matériau')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('chantier_id')
                            ->label('Chantier / Dépôt')
                            ->relationship('chantier', 'nom')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('article_id')
                            ->label('Matériau / Article')
                            ->relationship('article', 'designation')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Forms\Components\Section::make('Paramètres & Quantités en Stock')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('quantite_actuelle')
                            ->label('Quantité en Stock')
                            ->numeric()
                            ->default(0.00)
                            ->required(),
                        Forms\Components\TextInput::make('seuil_alerte_min')
                            ->label('Seuil d\'Alerte Minimum')
                            ->numeric()
                            ->default(10.00)
                            ->helperText('Déclenche une alerte visuelle si le stock descend sous cette valeur.')
                            ->required(),
                        Forms\Components\TextInput::make('emplacement')
                            ->label('Emplacement de Stockage')
                            ->placeholder('ex: Magasin central, Parc ferraillage, Zone A')
                            ->maxLength(100),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['chantier', 'article']))
            ->columns([
                Tables\Columns\TextColumn::make('chantier.nom')
                    ->label('Chantier')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('article.code')
                    ->label('Réf')
                    ->fontFamily('mono')
                    ->color('gray')
                    ->searchable(),

                Tables\Columns\TextColumn::make('article.designation')
                    ->label('Désignation Matériau')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('article.categorie')
                    ->label('Catégorie')
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('quantite_actuelle')
                    ->label('Stock Réel')
                    ->weight('bold')
                    ->formatStateUsing(fn ($state, Stock $record) => number_format((float) $state, 2, ',', ' ') . ' ' . ($record->article?->unite ?? 'U'))
                    ->color(fn (Stock $record): string => match (true) {
                        $record->quantite_actuelle <= 0 => 'danger',
                        $record->quantite_actuelle <= $record->seuil_alerte_min => 'warning',
                        default => 'success',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('seuil_alerte_min')
                    ->label('Seuil Min')
                    ->formatStateUsing(fn ($state, Stock $record) => number_format((float) $state, 2, ',', ' ') . ' ' . ($record->article?->unite ?? 'U'))
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('statut')
                    ->label('Disponibilité')
                    ->badge()
                    ->state(function (Stock $record): string {
                        if ($record->quantite_actuelle <= 0) {
                            return 'Rupture';
                        }
                        if ($record->quantite_actuelle <= $record->seuil_alerte_min) {
                            return 'Alerte Seuil';
                        }
                        return 'Normal';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Rupture' => 'danger',
                        'Alerte Seuil' => 'warning',
                        default => 'success',
                    }),

                Tables\Columns\TextColumn::make('valeur_estimee')
                    ->label('Valeur Estimée')
                    ->money('MAD')
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('quantite_actuelle', $direction))
                    ->toggleable(),

                Tables\Columns\TextColumn::make('emplacement')
                    ->label('Emplacement')
                    ->color('gray')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('derniere_entree_at')
                    ->label('Dernière Entrée')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('derniere_sortie_at')
                    ->label('Dernière Sortie')
                    ->dateTime('d/m/Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('quantite_actuelle', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('chantier_id')
                    ->label('Filtrer par Chantier')
                    ->relationship('chantier', 'nom'),

                Tables\Filters\SelectFilter::make('categorie')
                    ->label('Catégorie Matériau')
                    ->relationship('article', 'categorie'),

                Tables\Filters\Filter::make('alerte_stock')
                    ->label('⚠️ En Alerte / Rupture uniquement')
                    ->query(fn (Builder $query): Builder => $query->whereColumn('quantite_actuelle', '<=', 'seuil_alerte_min')),
            ])
            ->actions([
                // 1. Action Sortie Chantier
                Tables\Actions\Action::make('sortie')
                    ->label('Sortie')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('warning')
                    ->modalHeading(fn (Stock $record) => "Sortie de Stock : {$record->article?->designation}")
                    ->modalSubheading(fn (Stock $record) => "Chantier : {$record->chantier?->nom} | Disponible : {$record->quantite_actuelle} {$record->article?->unite}")
                    ->form([
                        Forms\Components\TextInput::make('quantite')
                            ->label('Quantité à Sortir')
                            ->numeric()
                            ->required()
                            ->minValue(0.01)
                            ->helperText(fn (Stock $record) => "Stock disponible : {$record->quantite_actuelle} {$record->article?->unite}"),
                        Forms\Components\Select::make('type_mouvement')
                            ->label('Nature de la Sortie')
                            ->options([
                                'sortie_consommation' => 'Consommation dans les travaux',
                                'sortie_perte_casse' => 'Perte / Casse / Avarie',
                            ])
                            ->default('sortie_consommation')
                            ->required(),
                        Forms\Components\TextInput::make('lot_ouvrage')
                            ->label('Lot / Zone de l\'Ouvrage')
                            ->placeholder('ex: Gros Œuvre Bâtiment A, Dallage Sous-sol')
                            ->required(),
                        Forms\Components\TextInput::make('motif_usage')
                            ->label('Précision / Tâche')
                            ->placeholder('ex: Coulage poteaux R+1, Mur de clôture')
                            ->required(),
                    ])
                    ->action(function (Stock $record, array $data): void {
                        try {
                            app(StockService::class)->enregistrerSortie(
                                chantierId: $record->chantier_id,
                                articleId: $record->article_id,
                                quantite: (float) $data['quantite'],
                                userId: auth()->id() ?? 1,
                                type: $data['type_mouvement'],
                                motif: $data['motif_usage'],
                                lot: $data['lot_ouvrage'],
                                autoriserNegatif: false
                            );

                            Notification::make()
                                ->title('Sortie enregistrée')
                                ->body("{$data['quantite']} {$record->article?->unite} de {$record->article?->designation} ont été décomptés du stock.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Opération refusée')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // 2. Action Transfert Inter-Chantiers
                Tables\Actions\Action::make('transfert')
                    ->label('Transfert')
                    ->icon('heroicon-o-arrows-right-left')
                    ->color('primary')
                    ->modalHeading(fn (Stock $record) => "Transférer du stock : {$record->article?->designation}")
                    ->modalSubheading(fn (Stock $record) => "Chantier Source : {$record->chantier?->nom} (Disponible : {$record->quantite_actuelle} {$record->article?->unite})")
                    ->form([
                        Forms\Components\Select::make('chantier_destination_id')
                            ->label('Chantier de Destination')
                            ->options(fn (Stock $record) => Chantier::where('id', '!=', $record->chantier_id)->pluck('nom', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('quantite')
                            ->label('Quantité à Transférer')
                            ->numeric()
                            ->required()
                            ->minValue(0.01)
                            ->helperText(fn (Stock $record) => "Maximum transférable : {$record->quantite_actuelle} {$record->article?->unite}"),
                        Forms\Components\TextInput::make('motif_usage')
                            ->label('Motif du Transfert')
                            ->placeholder('ex: Dépannage urgent coulage Tanger')
                            ->required(),
                    ])
                    ->action(function (Stock $record, array $data): void {
                        try {
                            $destChantier = Chantier::find($data['chantier_destination_id']);

                            app(StockService::class)->enregistrerTransfert(
                                sourceChantierId: $record->chantier_id,
                                destChantierId: (int) $data['chantier_destination_id'],
                                articleId: $record->article_id,
                                quantite: (float) $data['quantite'],
                                userId: auth()->id() ?? 1,
                                motif: $data['motif_usage']
                            );

                            Notification::make()
                                ->title('Transfert validé')
                                ->body("{$data['quantite']} {$record->article?->unite} transférés vers {$destChantier?->nom}.")
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('Échec du transfert')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // 3. Action Ajustement Inventaire
                Tables\Actions\Action::make('ajustement')
                    ->label('Inventaire')
                    ->icon('heroicon-o-scale')
                    ->color('gray')
                    ->modalHeading(fn (Stock $record) => "Ajustement d'Inventaire : {$record->article?->designation}")
                    ->form([
                        Forms\Components\TextInput::make('nouvelle_quantite')
                            ->label('Quantité Physique Réelle')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->helperText(fn (Stock $record) => "Stock théorique actuel : {$record->quantite_actuelle} {$record->article?->unite}"),
                        Forms\Components\Textarea::make('justification')
                            ->label('Justification de l\'écart')
                            ->placeholder('ex: Comptage physique mensuel au 31/10, écart constaté')
                            ->required(),
                    ])
                    ->action(function (Stock $record, array $data): void {
                        app(StockService::class)->ajusterInventaire(
                            chantierId: $record->chantier_id,
                            articleId: $record->article_id,
                            nouvelleQuantite: (float) $data['nouvelle_quantite'],
                            userId: auth()->id() ?? 1,
                            justification: $data['justification']
                        );

                        Notification::make()
                            ->title('Inventaire mis à jour')
                            ->body("Nouveau stock défini à {$data['nouvelle_quantite']} {$record->article?->unite}.")
                            ->success()
                            ->send();
                    }),

                // 4. Action Déclencher Demande d'Achat si alerte
                Tables\Actions\Action::make('reapprovisionner')
                    ->label('Commander (DA)')
                    ->icon('heroicon-o-shopping-cart')
                    ->color('danger')
                    ->visible(fn (Stock $record) => $record->quantite_actuelle <= $record->seuil_alerte_min)
                    ->url(fn (Stock $record) => DemandeAchatResource::getUrl('create')),

                Tables\Actions\EditAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
