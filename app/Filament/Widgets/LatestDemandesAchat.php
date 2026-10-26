<?php

namespace App\Filament\Widgets;

use App\Models\DemandeAchat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestDemandesAchat extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                DemandeAchat::query()->latest()->limit(5)
            )
            ->heading('Dernières Demandes d\'Achat des Chantiers')
            ->columns([
                Tables\Columns\TextColumn::make('numero_da')
                    ->label('N° DA')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('chantier.nom')
                    ->label('Chantier'),
                Tables\Columns\TextColumn::make('chantier.ville.nom')
                    ->label('Ville')
                    ->badge()
                    ->color('gray'),
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
                        'en_attente_conducteur' => 'warning',
                        'valide_conducteur' => 'info',
                        'en_attente_dg' => 'warning',
                        'approuve' => 'success',
                        'commande' => 'primary',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'en_attente_conducteur' => 'En attente Conducteur',
                        'valide_conducteur' => 'Validé Conducteur',
                        'en_attente_dg' => 'En attente DG',
                        'approuve' => 'Approuvé',
                        'commande' => 'Commandé',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('date_besoin')
                    ->label('Besoin le')
                    ->date('d/m/Y'),
            ]);
    }
}
