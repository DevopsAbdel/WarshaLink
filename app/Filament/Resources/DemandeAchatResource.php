<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DemandeAchatResource\Pages;
use App\Models\ArticleCatalogue;
use App\Models\BonCommande;
use App\Models\DemandeAchat;
use App\Models\Fournisseur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class DemandeAchatResource extends Resource
{
    protected static ?string $model = DemandeAchat::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = '🛒 Achats & Appro';

    protected static ?string $modelLabel = 'Demande d\'Achat';

    protected static ?string $pluralModelLabel = 'Demandes d\'Achat (DA)';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('En-tête de la Demande')
                            ->columns(3)
                            ->schema([
                                Forms\Components\TextInput::make('numero_da')
                                    ->label('N° DA')
                                    ->default(fn () => 'DA-' . date('Ymd') . '-' . rand(100, 999))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->readOnly(),
                                Forms\Components\Select::make('chantier_id')
                                    ->label('Chantier Demandeur')
                                    ->relationship('chantier', 'nom')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Forms\Components\Select::make('urgence')
                                    ->label('Degré d\'Urgence')
                                    ->options([
                                        'normal' => '🟢 Normal (48h - 72h)',
                                        'urgent' => '🟠 Urgent (24h)',
                                        'bloquant' => '🔴 Bloquant (Chantier à l\'arrêt)',
                                    ])
                                    ->default('normal')
                                    ->required(),
                                Forms\Components\DatePicker::make('date_besoin')
                                    ->label('Date requise sur chantier')
                                    ->default(now()->addDays(2))
                                    ->required(),
                                Forms\Components\Hidden::make('demandeur_id')
                                    ->default(fn () => Auth::id() ?? 1),
                                Forms\Components\Textarea::make('motif')
                                    ->label('Motif du besoin / Emplacement (ex: RDC Trame B)')
                                    ->columnSpanFull()
                                    ->rows(2),
                            ]),

                        Forms\Components\Section::make('Matériaux & Quantités Demandés')
                            ->schema([
                                Forms\Components\Repeater::make('lignesAchat')
                                    ->relationship('lignesAchat')
                                    ->schema([
                                        Forms\Components\Select::make('article_id')
                                            ->label('Depuis le Catalogue')
                                            ->options(ArticleCatalogue::all()->pluck('designation', 'id'))
                                            ->searchable()
                                            ->live()
                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                if ($state) {
                                                    $art = ArticleCatalogue::find($state);
                                                    if ($art) {
                                                        $set('designation', $art->designation);
                                                        $set('unite', $art->unite);
                                                        $set('prix_unitaire_estime', $art->prix_indicatif_ht);
                                                    }
                                                }
                                            })
                                            ->columnSpan(4),
                                        Forms\Components\TextInput::make('designation')
                                            ->label('Désignation')
                                            ->required()
                                            ->columnSpan(4),
                                        Forms\Components\TextInput::make('unite')
                                            ->label('Unité')
                                            ->placeholder('Sac, Tonne, m3...')
                                            ->required()
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('quantite_demandee')
                                            ->label('Quantité')
                                            ->numeric()
                                            ->required()
                                            ->live()
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('prix_unitaire_estime')
                                            ->label('Prix Estimé HT (MAD)')
                                            ->numeric()
                                            ->prefix('MAD')
                                            ->columnSpan(3),
                                        Forms\Components\TextInput::make('remarques')
                                            ->label('Précisions techniques / Marque souhaitée')
                                            ->columnSpan(9),
                                    ])
                                    ->columns(12)
                                    ->defaultItems(1)
                                    ->addActionLabel('Ajouter un matériau à la demande')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Circuit de Validation & Statut')
                            ->schema([
                                Forms\Components\Select::make('statut')
                                    ->label('État de la Demande')
                                    ->options([
                                        'brouillon' => 'Brouillon',
                                        'en_attente_conducteur' => 'En attente Conducteur de travaux',
                                        'valide_conducteur' => 'Validé par le Conducteur',
                                        'en_attente_dg' => 'En attente Direction Générale (>10k)',
                                        'approuve' => 'Approuvé (Prêt pour Bon de Commande)',
                                        'rejete' => 'Rejeté',
                                        'commande' => 'Bon de Commande Émis',
                                        'livre_partiel' => 'Livraison Partielle',
                                        'livre_total' => 'Livré Totalement',
                                    ])
                                    ->default('en_attente_conducteur')
                                    ->required(),
                                Forms\Components\TextInput::make('montant_estime_total_ht')
                                    ->label('Montant Estimé Total HT')
                                    ->numeric()
                                    ->prefix('MAD')
                                    ->default(0),
                                Forms\Components\FileUpload::make('justificatif_photo_path')
                                    ->label('Photo / Justificatif Terrain')
                                    ->image()
                                    ->directory('justificatifs_da')
                                    ->imageEditor(),
                                Forms\Components\Textarea::make('motif_rejet')
                                    ->label('Motif en cas de rejet')
                                    ->visible(fn (Forms\Get $get) => $get('statut') === 'rejete')
                                    ->rows(2),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_da')
                    ->label('N° DA')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('chantier.nom')
                    ->label('Chantier')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('chantier.ville.nom')
                    ->label('Ville')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('demandeur.name')
                    ->label('Émise par'),
                Tables\Columns\TextColumn::make('urgence')
                    ->label('Urgence')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'bloquant' => 'danger',
                        'urgent' => 'warning',
                        default => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'bloquant' => '🔴 Bloquant',
                        'urgent' => '🟠 Urgent',
                        default => '🟢 Normal',
                    }),
                Tables\Columns\TextColumn::make('statut')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'brouillon' => 'gray',
                        'en_attente_conducteur' => 'warning',
                        'valide_conducteur' => 'info',
                        'en_attente_dg' => 'warning',
                        'approuve' => 'success',
                        'rejete' => 'danger',
                        'commande' => 'primary',
                        'livre_total' => 'success',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'brouillon' => 'Brouillon',
                        'en_attente_conducteur' => 'En attente Conducteur',
                        'valide_conducteur' => 'Validé Conducteur',
                        'en_attente_dg' => 'En attente DG (>10k)',
                        'approuve' => 'Approuvé',
                        'rejete' => 'Rejeté',
                        'commande' => 'Commandé',
                        'livre_partiel' => 'Livré partiel',
                        'livre_total' => 'Livré total',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('date_besoin')
                    ->label('Besoin le')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('chantier_id')
                    ->label('Chantier')
                    ->relationship('chantier', 'nom'),
                Tables\Filters\SelectFilter::make('urgence')
                    ->options([
                        'normal' => 'Normal',
                        'urgent' => 'Urgent',
                        'bloquant' => 'Bloquant',
                    ]),
                Tables\Filters\SelectFilter::make('statut')
                    ->options([
                        'en_attente_conducteur' => 'En attente Conducteur',
                        'valide_conducteur' => 'Validé Conducteur',
                        'en_attente_dg' => 'En attente DG',
                        'approuve' => 'Approuvé',
                        'commande' => 'Commandé',
                    ]),
            ])
            ->actions([
                // 1. Action de validation Conducteur de Travaux
                Tables\Actions\Action::make('valider_conducteur')
                    ->label('Valider (Conducteur)')
                    ->icon('heroicon-o-check-circle')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Validation Technique par le Conducteur de Travaux')
                    ->modalDescription('Confirmez-vous que ce besoin est justifié pour le chantier ?')
                    ->visible(fn (DemandeAchat $record) => in_array($record->statut, ['en_attente_conducteur', 'brouillon']))
                    ->action(function (DemandeAchat $record) {
                        // Si le montant estimé dépasse 10 000 MAD, requiert la DG
                        $prochainStatut = ($record->montant_estime_total_ht > 10000) ? 'en_attente_dg' : 'approuve';
                        $record->update([
                            'statut' => $prochainStatut,
                            'conducteur_valideur_id' => Auth::id() ?? 1,
                            'date_validation_conducteur' => now(),
                        ]);

                        Notification::make()
                            ->title('Validation Conducteur enregistrée')
                            ->body($prochainStatut === 'en_attente_dg' ? 'Montant > 10 000 MAD : Transmis à la Direction Générale' : 'Demande approuvée pour achat !')
                            ->success()
                            ->send();
                    }),

                // 2. Action de validation Direction Générale
                Tables\Actions\Action::make('valider_dg')
                    ->label('Valider (Direction)')
                    ->icon('heroicon-o-shield-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Validation Financière de la Direction Générale')
                    ->visible(fn (DemandeAchat $record) => $record->statut === 'en_attente_dg')
                    ->action(function (DemandeAchat $record) {
                        $record->update([
                            'statut' => 'approuve',
                            'dg_valideur_id' => Auth::id() ?? 1,
                            'date_validation_dg' => now(),
                        ]);

                        Notification::make()
                            ->title('Validation Direction accordée')
                            ->body('La demande d\'achat est maintenant approuvée pour émission du bon de commande.')
                            ->success()
                            ->send();
                    }),

                // 3. Action de rejet
                Tables\Actions\Action::make('rejeter')
                    ->label('Rejeter')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('motif_rejet')
                            ->label('Motif du rejet / explications')
                            ->required(),
                    ])
                    ->visible(fn (DemandeAchat $record) => in_array($record->statut, ['en_attente_conducteur', 'en_attente_dg', 'valide_conducteur']))
                    ->action(function (DemandeAchat $record, array $data) {
                        $record->update([
                            'statut' => 'rejete',
                            'motif_rejet' => $data['motif_rejet'],
                        ]);

                        Notification::make()
                            ->title('Demande d\'achat rejetée')
                            ->danger()
                            ->send();
                    }),

                // 4. Action Émettre Bon de Commande (Service Achats)
                Tables\Actions\Action::make('generer_bc')
                    ->label('Émettre Bon de Commande')
                    ->icon('heroicon-o-document-plus')
                    ->color('primary')
                    ->visible(fn (DemandeAchat $record) => $record->statut === 'approuve')
                    ->form([
                        Forms\Components\Select::make('fournisseur_id')
                            ->label('Fournisseur Sélectionné')
                            ->options(Fournisseur::all()->pluck('nom', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\DatePicker::make('date_commande')
                            ->label('Date de Commande')
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('delai_livraison_prevu')
                            ->label('Date prévue de livraison sur chantier')
                            ->default(now()->addDays(2)),
                        Forms\Components\TextInput::make('conditions_paiement')
                            ->label('Conditions de Règlement')
                            ->default('60 jours fin de mois')
                            ->placeholder('ex: À la livraison, 30j, 60j'),
                        Forms\Components\TextInput::make('montant_total_ht')
                            ->label('Montant Négocié Total HT (MAD)')
                            ->numeric()
                            ->prefix('MAD')
                            ->required(),
                    ])
                    ->action(function (DemandeAchat $record, array $data) {
                        $tauxTva = 20.00; // TVA Maroc = 20%
                        $montantHt = (float) $data['montant_total_ht'];
                        $montantTva = $montantHt * ($tauxTva / 100);
                        $montantTtc = $montantHt + $montantTva;

                        $bc = BonCommande::create([
                            'demande_achat_id' => $record->id,
                            'fournisseur_id' => $data['fournisseur_id'],
                            'cree_par_id' => Auth::id() ?? 1,
                            'numero_bc' => 'BC-' . date('Ymd') . '-' . rand(100, 999),
                            'date_commande' => $data['date_commande'],
                            'delai_livraison_prevu' => $data['delai_livraison_prevu'],
                            'conditions_paiement' => $data['conditions_paiement'],
                            'montant_total_ht' => $montantHt,
                            'taux_tva' => $tauxTva,
                            'montant_tva' => $montantTva,
                            'montant_total_ttc' => $montantTtc,
                            'statut' => 'emis',
                        ]);

                        $record->update(['statut' => 'commande']);

                        Notification::make()
                            ->title('Bon de Commande émis avec succès !')
                            ->body("N° BC : {$bc->numero_bc} - Montant TTC : " . number_format($montantTtc, 2, ',', ' ') . " MAD")
                            ->success()
                            ->send();
                    }),

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
            'index' => Pages\ListDemandeAchats::route('/'),
            'create' => Pages\CreateDemandeAchat::route('/create'),
            'edit' => Pages\EditDemandeAchat::route('/{record}/edit'),
        ];
    }
}
