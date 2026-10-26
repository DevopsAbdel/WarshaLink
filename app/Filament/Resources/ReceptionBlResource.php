<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceptionBlResource\Pages;
use App\Models\BonCommande;
use App\Models\ReceptionBl;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ReceptionBlResource extends Resource
{
    protected static ?string $model = ReceptionBl::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = '🛒 Achats & Appro';

    protected static ?string $modelLabel = 'Réception Chantier (BL)';

    protected static ?string $pluralModelLabel = 'Réceptions Chantier (BL)';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Détails de la Réception sur Site')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('bon_commande_id')
                            ->label('Bon de Commande Associé')
                            ->relationship('bonCommande', 'numero_bc')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $bc = BonCommande::with('demandeAchat')->find($state);
                                    if ($bc && $bc->demandeAchat) {
                                        $set('chantier_id', $bc->demandeAchat->chantier_id);
                                    }
                                }
                            }),
                        Forms\Components\Select::make('chantier_id')
                            ->label('Chantier Réceptionnaire')
                            ->relationship('chantier', 'nom')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('numero_bl_fournisseur')
                            ->label('N° Bon de Livraison Fournisseur')
                            ->placeholder('ex: BL-LAF-98234')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\DateTimePicker::make('date_reception')
                            ->label('Date & Heure de Réception')
                            ->default(now())
                            ->required(),
                        Forms\Components\Select::make('statut_conformite')
                            ->label('Contrôle de Conformité')
                            ->options([
                                'conforme' => '✅ Conforme (Quantités & Qualité OK)',
                                'partiel' => '⚠️ Livraison Partielle (Reliquat restant)',
                                'non_conforme_avarie' => '❌ Non Conforme / Avarie constatée',
                            ])
                            ->default('conforme')
                            ->required(),
                        Forms\Components\Hidden::make('receptionnaire_id')
                            ->default(fn () => Auth::id() ?? 1),
                    ]),

                Forms\Components\Section::make('Preuve de Réception & Justificatif Terrain')
                    ->description('Prenez en photo le bon de livraison physique papier dûment tamponné et signé par le transporteur.')
                    ->schema([
                        Forms\Components\FileUpload::make('photo_bl_path')
                            ->label('Photo du Bon de Livraison (BL) Signé')
                            ->image()
                            ->directory('bons_livraison')
                            ->imageEditor()
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('observations')
                            ->label('Remarques & Réserves éventuelles (Casse, sac déchiré, retard...)')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_bl_fournisseur')
                    ->label('N° BL Fournisseur')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('bonCommande.numero_bc')
                    ->label('N° Commande')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('chantier.nom')
                    ->label('Chantier')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_reception')
                    ->label('Date Réception')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('receptionnaire.name')
                    ->label('Réceptionné par'),
                Tables\Columns\TextColumn::make('statut_conformite')
                    ->label('Conformité')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'conforme' => 'success',
                        'partiel' => 'warning',
                        'non_conforme_avarie' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'conforme' => 'Conforme',
                        'partiel' => 'Partielle',
                        'non_conforme_avarie' => 'Avarie / Rejet',
                        default => $state,
                    }),
                Tables\Columns\ImageColumn::make('photo_bl_path')
                    ->label('BL Signé')
                    ->circular(),
            ])
            ->defaultSort('date_reception', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('chantier_id')
                    ->label('Chantier')
                    ->relationship('chantier', 'nom'),
                Tables\Filters\SelectFilter::make('statut_conformite')
                    ->options([
                        'conforme' => 'Conforme',
                        'partiel' => 'Partielle',
                        'non_conforme_avarie' => 'Avarie / Rejet',
                    ]),
            ])
            ->actions([
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
            'index' => Pages\ListReceptionBls::route('/'),
            'create' => Pages\CreateReceptionBl::route('/create'),
            'edit' => Pages\EditReceptionBl::route('/{record}/edit'),
        ];
    }
}
