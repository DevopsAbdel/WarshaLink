<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PointageResource\Pages;
use App\Models\Chantier;
use App\Models\Employe;
use App\Models\Pointage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PointageResource extends Resource
{
    protected static ?string $model = Pointage::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = '👷 Pointage & RH';

    protected static ?string $modelLabel = 'Pointage Journalier';

    protected static ?string $pluralModelLabel = 'Pointages des Chantiers';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Enregistrement du Pointage')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('chantier_id')
                            ->label('Chantier')
                            ->relationship('chantier', 'nom')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('employe_id')
                            ->label('Ouvrier')
                            ->options(Employe::where('is_actif', true)->get()->pluck('nom_complet', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\DatePicker::make('date_pointage')
                            ->label('Date de Présence')
                            ->default(now())
                            ->required(),
                        Forms\Components\Select::make('statut_presence')
                            ->label('Statut de Présence')
                            ->options([
                                'present' => '🟢 Présent (Journée Complète)',
                                'demi_journee' => '🟡 Demi-Journée',
                                'absent_injustifie' => '🔴 Absent Injustifié',
                                'absent_justifie' => '⚪ Absent Justifié / Autorisé',
                                'conge' => '🏖️ Congé',
                                'accident_travail' => '⚠️ Accident du Travail',
                            ])
                            ->default('present')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state === 'present') {
                                    $set('heures_normales', 8.0);
                                } elseif ($state === 'demi_journee') {
                                    $set('heures_normales', 4.0);
                                } else {
                                    $set('heures_normales', 0.0);
                                }
                            }),
                        Forms\Components\TextInput::make('heures_normales')
                            ->label('Heures Normales')
                            ->numeric()
                            ->default(8.0)
                            ->suffix('h')
                            ->required(),
                        Forms\Components\TextInput::make('heures_sup')
                            ->label('Heures Supplémentaires (HS)')
                            ->numeric()
                            ->default(0.0)
                            ->suffix('h'),
                        Forms\Components\Hidden::make('pointeur_id')
                            ->default(fn () => Auth::id() ?? 1),
                    ]),

                Forms\Components\Section::make('Contrôle Géolocalisation Chantier & Validation')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('latitude_pointage')
                            ->label('Latitude capturée')
                            ->numeric(),
                        Forms\Components\TextInput::make('longitude_pointage')
                            ->label('Longitude capturée')
                            ->numeric(),
                        Forms\Components\Toggle::make('is_geoloc_valide')
                            ->label('Pointage validé dans le périmètre GPS')
                            ->default(true),
                        Forms\Components\Textarea::make('remarques')
                            ->label('Remarques (ex: Coulage de béton nuit, retard justifié transport)')
                            ->columnSpanFull()
                            ->rows(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_pointage')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('chantier.nom')
                    ->label('Chantier')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('employe.nom_complet')
                    ->label('Ouvrier')
                    ->searchable(['employes.nom', 'employes.prenom'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('employe.specialite')
                    ->label('Métier')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('statut_presence')
                    ->label('Présence')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'demi_journee' => 'warning',
                        'absent_injustifie' => 'danger',
                        'absent_justifie' => 'info',
                        'conge' => 'gray',
                        'accident_travail' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'present' => 'Présent',
                        'demi_journee' => '1/2 Journée',
                        'absent_injustifie' => 'Absent Injustifié',
                        'absent_justifie' => 'Absent Justifié',
                        'conge' => 'Congé',
                        'accident_travail' => 'Accident',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('heures_normales')
                    ->label('H. Normales')
                    ->suffix(' h')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('heures_sup')
                    ->label('HS')
                    ->suffix(' h')
                    ->color('warning')
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('is_geoloc_valide')
                    ->label('GPS')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-map-pin'),
                Tables\Columns\TextColumn::make('conducteurValideur.name')
                    ->label('Validé par')
                    ->placeholder('En attente'),
            ])
            ->defaultSort('date_pointage', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('chantier_id')
                    ->label('Chantier')
                    ->relationship('chantier', 'nom'),
                Tables\Filters\SelectFilter::make('statut_presence')
                    ->label('Présence')
                    ->options([
                        'present' => 'Présent',
                        'demi_journee' => 'Demi-journée',
                        'absent_injustifie' => 'Absent Injustifié',
                        'absent_justifie' => 'Absent Justifié',
                    ]),
            ])
            ->headerActions([
                // 1. Action Saisie Rapide Chantier : Pointe toute l'équipe présente en 1 clic !
                Tables\Actions\Action::make('pointage_rapide_equipe')
                    ->label('⚡ Pointage Rapide de l\'Équipe (Journée)')
                    ->icon('heroicon-o-bolt')
                    ->color('success')
                    ->form([
                        Forms\Components\Select::make('chantier_id')
                            ->label('Sélectionner le Chantier à pointer')
                            ->options(Chantier::where('statut', 'en_cours')->pluck('nom', 'id'))
                            ->required(),
                        Forms\Components\DatePicker::make('date_pointage')
                            ->label('Date de Pointage')
                            ->default(now())
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $chantierId = $data['chantier_id'];
                        $date = \Carbon\Carbon::parse($data['date_pointage'])->format('Y-m-d');
                        $userId = Auth::id() ?? 1;

                        $employes = Employe::where('chantier_actuel_id', $chantierId)
                            ->where('is_actif', true)
                            ->get();

                        if ($employes->isEmpty()) {
                            $employes = Employe::where('is_actif', true)->take(10)->get();
                        }

                        $count = 0;
                        foreach ($employes as $emp) {
                            Pointage::updateOrCreate(
                                [
                                    'chantier_id' => $chantierId,
                                    'employe_id' => $emp->id,
                                    'date_pointage' => $date,
                                ],
                                [
                                    'pointeur_id' => $userId,
                                    'statut_presence' => 'present',
                                    'heures_normales' => 8.0,
                                    'heures_sup' => 0.0,
                                    'is_geoloc_valide' => true,
                                ]
                            );
                            $count++;
                        }

                        Notification::make()
                            ->title("Pointage rapide enregistré !")
                            ->body("{$count} ouvriers ont été enregistrés ou actualisés (8h) pour la date du {$date}.")
                            ->success()
                            ->send();
                    }),

                // 2. Action Validation Hebdomadaire par le Conducteur de Travaux
                Tables\Actions\Action::make('validation_conducteur_masse')
                    ->label('✅ Valider la Semaine (Conducteur)')
                    ->icon('heroicon-o-shield-check')
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading('Validation des fiches de pointage')
                    ->modalDescription('Confirmez-vous la conformité des heures saisies avant transmission à la comptabilité et paie ?')
                    ->form([
                        Forms\Components\Select::make('chantier_id')
                            ->label('Chantier à valider')
                            ->options(Chantier::all()->pluck('nom', 'id'))
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $updated = Pointage::where('chantier_id', $data['chantier_id'])
                            ->whereNull('valide_par_conducteur_id')
                            ->update([
                                'valide_par_conducteur_id' => Auth::id() ?? 1,
                                'date_validation_conducteur' => now(),
                            ]);

                        Notification::make()
                            ->title('Pointages validés avec succès !')
                            ->body("{$updated} enregistrements de pointage ont été certifiés par le conducteur.")
                            ->success()
                            ->send();
                    }),
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
            'index' => Pages\ListPointages::route('/'),
            'create' => Pages\CreatePointage::route('/create'),
            'edit' => Pages\EditPointage::route('/{record}/edit'),
        ];
    }
}
