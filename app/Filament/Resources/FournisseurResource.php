<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FournisseurResource\Pages;
use App\Models\Fournisseur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FournisseurResource extends Resource
{
    protected static ?string $model = Fournisseur::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = '🛒 Achats & Appro';

    protected static ?string $modelLabel = 'Fournisseur';

    protected static ?string $pluralModelLabel = 'Fournisseurs';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identité du Fournisseur')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('nom')
                            ->label('Raison Sociale')
                            ->required()
                            ->maxLength(190),
                        Forms\Components\TextInput::make('ice')
                            ->label('N° ICE (Maroc)')
                            ->placeholder('ex: 000012345000088')
                            ->maxLength(30),
                        Forms\Components\TextInput::make('ville')
                            ->label('Ville du Siège / Dépôt')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('contact_nom')
                            ->label('Nom de l\'interlocuteur commercial')
                            ->maxLength(100),
                    ]),

                Forms\Components\Section::make('Coordonnées & Règlement')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('telephone')
                            ->label('Téléphone')
                            ->tel()
                            ->maxLength(30),
                        Forms\Components\TextInput::make('email')
                            ->label('Email de commande')
                            ->email()
                            ->maxLength(100),
                        Forms\Components\Textarea::make('adresse')
                            ->label('Adresse du dépôt / usine')
                            ->columnSpanFull()
                            ->rows(2),
                        Forms\Components\TextInput::make('rib')
                            ->label('RIB Bancaire (24 chiffres)')
                            ->placeholder('011780000012345678901234')
                            ->columnSpanFull()
                            ->maxLength(40),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->label('Fournisseur')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('ice')
                    ->label('ICE')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ville')
                    ->label('Ville')
                    ->badge()
                    ->color('gray')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('Téléphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_nom')
                    ->label('Contact'),
                Tables\Columns\TextColumn::make('bons_commande_count')
                    ->label('Commandes')
                    ->counts('bonsCommande')
                    ->badge()
                    ->color('success'),
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
            'index' => Pages\ListFournisseurs::route('/'),
            'create' => Pages\CreateFournisseur::route('/create'),
            'edit' => Pages\EditFournisseur::route('/{record}/edit'),
        ];
    }
}
