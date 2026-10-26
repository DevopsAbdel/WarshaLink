<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = '⚙️ Configuration';

    protected static ?string $modelLabel = 'Utilisateur / Collaborateur';

    protected static ?string $pluralModelLabel = 'Utilisateurs & Rôles';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identité & Accès')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nom & Prénom')
                            ->required()
                            ->maxLength(190),
                        Forms\Components\TextInput::make('email')
                            ->label('Adresse Email professionnelle')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(190),
                        Forms\Components\TextInput::make('password')
                            ->label('Mot de passe')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(190),
                        Forms\Components\TextInput::make('cin')
                            ->label('N° CIN')
                            ->placeholder('ex: BE123456')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('telephone')
                            ->label('Téléphone')
                            ->tel()
                            ->maxLength(25),
                        Forms\Components\TextInput::make('fonction')
                            ->label('Fonction dans l\'entreprise')
                            ->placeholder('ex: Chef de Chantier Tanger, Conducteur de Travaux')
                            ->maxLength(100),
                    ]),

                Forms\Components\Section::make('Rôles & Affectations aux Chantiers')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('roles')
                            ->label('Rôle dans l\'application')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('chantiers')
                            ->label('Chantiers Supervisés / Affectés')
                            ->relationship('chantiers', 'nom')
                            ->multiple()
                            ->preload()
                            ->searchable(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Compte actif et autorisé à se connecter')
                            ->default(true)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Collaborateur')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('Téléphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fonction')
                    ->label('Fonction')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Rôle')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'direction_generale' => 'Direction Générale',
                        'conducteur_travaux' => 'Conducteur Travaux',
                        'chef_chantier' => 'Chef de Chantier',
                        'responsable_achats' => 'Achats & Logistique',
                        'responsable_rh' => 'RH & Paie',
                        default => $state,
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
