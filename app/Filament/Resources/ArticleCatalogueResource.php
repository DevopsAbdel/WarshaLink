<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleCatalogueResource\Pages;
use App\Models\ArticleCatalogue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArticleCatalogueResource extends Resource
{
    protected static ?string $model = ArticleCatalogue::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = '🛒 Achats & Appro';

    protected static ?string $modelLabel = 'Article / Matériau';

    protected static ?string $pluralModelLabel = 'Catalogue Matériaux';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Code Article')
                    ->placeholder('ex: CIM-CPJ45')
                    ->maxLength(50),
                Forms\Components\TextInput::make('designation')
                    ->label('Désignation du Matériau')
                    ->required()
                    ->placeholder('ex: Ciment CPJ 45 (Sac 50kg)')
                    ->maxLength(190),
                Forms\Components\Select::make('categorie')
                    ->label('Catégorie BTP')
                    ->options([
                        'Gros Œuvre' => 'Gros Œuvre',
                        'Granulats' => 'Granulats (Sable, Gravette)',
                        'Ferraillage' => 'Ferraillage (Aciers & Barres)',
                        'Maçonnerie' => 'Maçonnerie (Briques, Parpaings)',
                        'Planchers' => 'Planchers & Hourdis',
                        'Plomberie & VRD' => 'Plomberie & VRD',
                        'Électricité' => 'Électricité & Câblage',
                        'Peinture & Finition' => 'Peinture & Finition',
                        'Outillage & EPI' => 'Outillage & Équipements de Sécurité',
                    ])
                    ->required(),
                Forms\Components\Select::make('unite')
                    ->label('Unité de Mesure')
                    ->options([
                        'Sac' => 'Sac (50kg)',
                        'Tonne' => 'Tonne',
                        'm3' => 'Mètre cube (m³)',
                        'Mille' => 'Mille unités (1000 pcs)',
                        'Barre' => 'Barre / Longueur',
                        'Couronne' => 'Couronne / Rouleau',
                        'm2' => 'Mètre carré (m²)',
                        'Litre' => 'Litre',
                        'Unité' => 'Unité / Pièce',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('prix_indicatif_ht')
                    ->label('Prix Indicatif HT (MAD)')
                    ->numeric()
                    ->prefix('MAD'),
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
                Tables\Columns\TextColumn::make('designation')
                    ->label('Désignation')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('categorie')
                    ->label('Catégorie')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unite')
                    ->label('Unité')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('prix_indicatif_ht')
                    ->label('Prix Indicatif')
                    ->money('MAD')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categorie')
                    ->label('Catégorie')
                    ->options([
                        'Gros Œuvre' => 'Gros Œuvre',
                        'Granulats' => 'Granulats',
                        'Ferraillage' => 'Ferraillage',
                        'Maçonnerie' => 'Maçonnerie',
                        'Planchers' => 'Planchers',
                        'Plomberie & VRD' => 'Plomberie & VRD',
                        'Électricité' => 'Électricité',
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
            'index' => Pages\ListArticleCatalogues::route('/'),
            'create' => Pages\CreateArticleCatalogue::route('/create'),
            'edit' => Pages\EditArticleCatalogue::route('/{record}/edit'),
        ];
    }
}
