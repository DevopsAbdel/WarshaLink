<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VilleResource\Pages;
use App\Models\Ville;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VilleResource extends Resource
{
    protected static ?string $model = Ville::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = '🏗️ Gestion Chantiers';

    protected static ?string $modelLabel = 'Ville';

    protected static ?string $pluralModelLabel = 'Villes';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->label('Nom de la Ville')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('region')
                    ->label('Région Administrative')
                    ->placeholder('ex: Tanger-Tétouan-Al Hoceïma')
                    ->maxLength(150),
                Forms\Components\TextInput::make('code_postal')
                    ->label('Code Postal')
                    ->placeholder('ex: 90000')
                    ->maxLength(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->label('Ville')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('region')
                    ->label('Région')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code_postal')
                    ->label('Code Postal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('chantiers_count')
                    ->label('Nb Chantiers')
                    ->counts('chantiers')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
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
            'index' => Pages\ListVilles::route('/'),
            'create' => Pages\CreateVille::route('/create'),
            'edit' => Pages\EditVille::route('/{record}/edit'),
        ];
    }
}
