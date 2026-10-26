<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeResource\Pages;
use App\Models\Employe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = '👷 Pointage & RH';

    protected static ?string $modelLabel = 'Ouvrier / Employé';

    protected static ?string $pluralModelLabel = 'Ouvriers & Équipes';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Fiche Ouvrier Terrain')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('matricule')
                            ->label('Matricule')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('ex: EMP-TNG-01')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('cin')
                            ->label('N° CIN (Maroc)')
                            ->placeholder('ex: BK123456')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('telephone')
                            ->label('N° Téléphone')
                            ->tel()
                            ->maxLength(30),
                        Forms\Components\TextInput::make('nom')
                            ->label('Nom')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('prenom')
                            ->label('Prénom')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\Select::make('specialite')
                            ->label('Corps d\'État / Métier')
                            ->options([
                                'chef_equipe' => '👑 Chef d\'Équipe',
                                'macon' => '🧱 Maçon',
                                'ferrailleur' => '⛓️ Ferrailleur',
                                'coffreur' => '🪵 Coffreur / Boiseur',
                                'grutier' => '🏗️ Grutier',
                                'conducteur_engin' => '🚜 Conducteur d\'Engin',
                                'electricien' => '⚡ Électricien',
                                'plombier' => '🔧 Plombier',
                                'peintre' => '🎨 Peintre',
                                'platrier' => 'Gipsier / Plâtrier',
                                'carreleur' => 'Carreleur',
                                'manoeuvre' => '👷 Manœuvre',
                                'gardien' => 'Gardien de chantier',
                                'autre' => 'Autre spécialité',
                            ])
                            ->default('manoeuvre')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Contrat & Rémunération')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('type_contrat')
                            ->label('Statut Juridique / Contrat')
                            ->options([
                                'permanent_cnss' => 'Salarié Déclaré CNSS',
                                'journalier_tacheron' => 'Journalier / Tâcheron (Payé à la journée)',
                                'sous_traitant' => 'Ouvrier Sous-Traitant',
                            ])
                            ->default('journalier_tacheron')
                            ->required(),
                        Forms\Components\TextInput::make('cout_journalier_mad')
                            ->label('Taux Journalier (MAD / Jour)')
                            ->numeric()
                            ->prefix('MAD')
                            ->default(150.00)
                            ->required(),
                        Forms\Components\Select::make('chantier_actuel_id')
                            ->label('Chantier d\'Affectation Actuel')
                            ->relationship('chantierActuel', 'nom')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Toggle::make('is_actif')
                            ->label('Ouvrier en activité')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matricule')
                    ->label('Matricule')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('nom_complet')
                    ->label('Nom & Prénom')
                    ->searchable(['nom', 'prenom'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('cin')
                    ->label('CIN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('specialite')
                    ->label('Métier')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'chef_equipe' => 'Chef d\'Équipe',
                        'macon' => 'Maçon',
                        'ferrailleur' => 'Ferrailleur',
                        'coffreur' => 'Coffreur',
                        'grutier' => 'Grutier',
                        'manoeuvre' => 'Manœuvre',
                        'electricien' => 'Électricien',
                        'plombier' => 'Plombier',
                        default => ucfirst($state),
                    }),
                Tables\Columns\TextColumn::make('type_contrat')
                    ->label('Type Contrat')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'permanent_cnss' => 'success',
                        'journalier_tacheron' => 'warning',
                        'sous_traitant' => 'gray',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'permanent_cnss' => 'Permanent CNSS',
                        'journalier_tacheron' => 'Journalier',
                        'sous_traitant' => 'Sous-traitant',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('chantierActuel.nom')
                    ->label('Chantier Actuel')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('cout_journalier_mad')
                    ->label('Taux / Jour')
                    ->money('MAD')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_actif')
                    ->label('Actif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('chantier_actuel_id')
                    ->label('Chantier')
                    ->relationship('chantierActuel', 'nom'),
                Tables\Filters\SelectFilter::make('specialite')
                    ->label('Métier')
                    ->options([
                        'chef_equipe' => 'Chef d\'Équipe',
                        'macon' => 'Maçon',
                        'ferrailleur' => 'Ferrailleur',
                        'coffreur' => 'Coffreur',
                        'grutier' => 'Grutier',
                        'manoeuvre' => 'Manœuvre',
                    ]),
                Tables\Filters\SelectFilter::make('type_contrat')
                    ->label('Contrat')
                    ->options([
                        'permanent_cnss' => 'Permanent CNSS',
                        'journalier_tacheron' => 'Journalier',
                        'sous_traitant' => 'Sous-traitant',
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
            'index' => Pages\ListEmployes::route('/'),
            'create' => Pages\CreateEmploye::route('/create'),
            'edit' => Pages\EditEmploye::route('/{record}/edit'),
        ];
    }
}
