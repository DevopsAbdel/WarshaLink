<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChantierResource\Pages;
use App\Models\Chantier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ChantierResource extends Resource
{
    protected static ?string $model = Chantier::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = '🏗️ Gestion Chantiers';

    protected static ?string $modelLabel = 'Chantier';

    protected static ?string $pluralModelLabel = 'Chantiers';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations Générales du Projet')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('Code Chantier')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('ex: CHT-TNG-001')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('nom')
                            ->label('Nom du Chantier')
                            ->required()
                            ->placeholder('ex: Tour Marina Bay Tanger')
                            ->maxLength(190),
                        Forms\Components\Select::make('ville_id')
                            ->label('Ville')
                            ->relationship('ville', 'nom')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('client')
                            ->label('Maître d\'Ouvrage / Client')
                            ->placeholder('ex: TMSA, Al Omrane, Privé')
                            ->maxLength(190),
                        Forms\Components\TextInput::make('budget_total')
                            ->label('Budget Total Alloué (MAD)')
                            ->numeric()
                            ->prefix('MAD')
                            ->default(0),
                        Forms\Components\Select::make('statut')
                            ->label('Statut du Chantier')
                            ->options([
                                'en_preparation' => 'En préparation',
                                'en_cours' => 'En cours d\'exécution',
                                'en_pause' => 'En pause / Arrêt temporaire',
                                'termine' => 'Travaux terminés',
                                'cloture' => 'Clôturé & Réceptionné',
                            ])
                            ->default('en_cours')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Localisation & Périmètre GPS de Pointage')
                    ->description('Les coordonnées GPS et le rayon permettent de vérifier la présence effective des ouvriers et chefs de chantier lors du pointage.')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Textarea::make('adresse')
                            ->label('Adresse physique')
                            ->columnSpanFull()
                            ->rows(2),
                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitude GPS')
                            ->numeric()
                            ->placeholder('ex: 35.7891234'),
                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitude GPS')
                            ->numeric()
                            ->placeholder('ex: -5.8123456'),
                        Forms\Components\TextInput::make('rayon_metres')
                            ->label('Rayon de Tolérance (Mètres)')
                            ->numeric()
                            ->default(300)
                            ->suffix('m')
                            ->helperText('Rayon max autour du chantier pour valider un pointage'),
                    ]),

                Forms\Components\Section::make('Planning & Personnel Assigné')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DatePicker::make('date_debut')
                            ->label('Date de démarrage des travaux'),
                        Forms\Components\DatePicker::make('date_fin_prevue')
                            ->label('Date prévisionnelle de livraison'),
                        Forms\Components\Select::make('users')
                            ->label('Équipe d\'encadrement (Conducteurs & Chefs)')
                            ->relationship('users', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('nom')
                    ->label('Chantier')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ville.nom')
                    ->label('Ville')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('client')
                    ->label('Client')
                    ->searchable(),
                Tables\Columns\TextColumn::make('budget_total')
                    ->label('Budget')
                    ->money('MAD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('statut')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'en_cours' => 'success',
                        'en_preparation' => 'warning',
                        'en_pause' => 'danger',
                        'termine' => 'info',
                        'cloture' => 'gray',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'en_preparation' => 'En préparation',
                        'en_cours' => 'En cours',
                        'en_pause' => 'En pause',
                        'termine' => 'Terminé',
                        'cloture' => 'Clôturé',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('employes_count')
                    ->label('Ouvriers')
                    ->counts('employes')
                    ->badge()
                    ->color('gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('ville_id')
                    ->label('Filtrer par Ville')
                    ->relationship('ville', 'nom'),
                Tables\Filters\SelectFilter::make('statut')
                    ->label('Statut')
                    ->options([
                        'en_preparation' => 'En préparation',
                        'en_cours' => 'En cours',
                        'en_pause' => 'En pause',
                        'termine' => 'Terminé',
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
            'index' => Pages\ListChantiers::route('/'),
            'create' => Pages\CreateChantier::route('/create'),
            'edit' => Pages\EditChantier::route('/{record}/edit'),
        ];
    }
}
