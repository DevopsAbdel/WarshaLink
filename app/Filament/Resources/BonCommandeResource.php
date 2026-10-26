<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BonCommandeResource\Pages;
use App\Models\BonCommande;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BonCommandeResource extends Resource
{
    protected static ?string $model = BonCommande::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = '🛒 Achats & Appro';

    protected static ?string $modelLabel = 'Bon de Commande';

    protected static ?string $pluralModelLabel = 'Bons de Commande (BC)';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Détails de la Commande')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('numero_bc')
                            ->label('N° Bon de Commande')
                            ->default(fn () => 'BC-' . date('Ymd') . '-' . rand(100, 999))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->readOnly(),
                        Forms\Components\Select::make('fournisseur_id')
                            ->label('Fournisseur')
                            ->relationship('fournisseur', 'nom')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('demande_achat_id')
                            ->label('Demande d\'Achat d\'origine')
                            ->relationship('demandeAchat', 'numero_da')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('date_commande')
                            ->label('Date de Commande')
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('delai_livraison_prevu')
                            ->label('Délai de Livraison Prévu')
                            ->default(now()->addDays(2)),
                        Forms\Components\TextInput::make('conditions_paiement')
                            ->label('Conditions de Paiement')
                            ->placeholder('ex: 60 jours fin de mois, À livraison'),
                    ]),

                Forms\Components\Section::make('Valorisation Financière (MAD)')
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('montant_total_ht')
                            ->label('Total HT')
                            ->numeric()
                            ->prefix('MAD')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $ht = (float) $state;
                                $taux = (float) ($get('taux_tva') ?? 20.00);
                                $tva = $ht * ($taux / 100);
                                $set('montant_tva', $tva);
                                $set('montant_total_ttc', $ht + $tva);
                            }),
                        Forms\Components\TextInput::make('taux_tva')
                            ->label('Taux TVA')
                            ->numeric()
                            ->suffix('%')
                            ->default(20.00)
                            ->required(),
                        Forms\Components\TextInput::make('montant_tva')
                            ->label('Montant TVA')
                            ->numeric()
                            ->prefix('MAD')
                            ->readOnly(),
                        Forms\Components\TextInput::make('montant_total_ttc')
                            ->label('Total Général TTC')
                            ->numeric()
                            ->prefix('MAD')
                            ->readOnly(),
                        Forms\Components\Select::make('statut')
                            ->label('État de la Commande')
                            ->options([
                                'emis' => 'Émis (En attente confirmation)',
                                'confirme_fournisseur' => 'Confirmé par Fournisseur',
                                'en_livraison' => 'En cours d\'acheminement',
                                'solde' => 'Livré & Soldé',
                                'annule' => 'Annulé',
                            ])
                            ->default('emis')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_bc')
                    ->label('N° BC')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('fournisseur.nom')
                    ->label('Fournisseur')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('demandeAchat.chantier.nom')
                    ->label('Chantier Livré')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('date_commande')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('montant_total_ttc')
                    ->label('Montant TTC')
                    ->money('MAD')
                    ->weight('bold')
                    ->sortable(),
                Tables\Columns\TextColumn::make('statut')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'emis' => 'warning',
                        'confirme_fournisseur' => 'info',
                        'en_livraison' => 'primary',
                        'solde' => 'success',
                        'annule' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'emis' => 'Émis',
                        'confirme_fournisseur' => 'Confirmé',
                        'en_livraison' => 'En livraison',
                        'solde' => 'Soldé',
                        'annule' => 'Annulé',
                        default => $state,
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('fournisseur_id')
                    ->label('Fournisseur')
                    ->relationship('fournisseur', 'nom'),
                Tables\Filters\SelectFilter::make('statut')
                    ->options([
                        'emis' => 'Émis',
                        'confirme_fournisseur' => 'Confirmé',
                        'en_livraison' => 'En livraison',
                        'solde' => 'Soldé',
                    ]),
            ])
            ->actions([
                // Action Téléchargement PDF
                Tables\Actions\Action::make('pdf')
                    ->label('Imprimer BC (PDF)')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('warning')
                    ->url(fn (BonCommande $record) => route('bon-commande.pdf', $record->id))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBonCommandes::route('/'),
            'create' => Pages\CreateBonCommande::route('/create'),
            'edit' => Pages\EditBonCommande::route('/{record}/edit'),
        ];
    }
}
