<?php

namespace App\Filament\Widgets;

use App\Models\BonCommande;
use App\Models\Chantier;
use App\Models\DemandeAchat;
use App\Models\Employe;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BtpOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $chantiersActifs = Chantier::where('statut', 'en_cours')->count();
        $totalOuvriers = Employe::where('is_actif', true)->count();
        $daEnAttente = DemandeAchat::whereIn('statut', ['en_attente_conducteur', 'en_attente_dg'])->count();
        $commandesMois = BonCommande::whereMonth('date_commande', now()->month)
            ->whereYear('date_commande', now()->year)
            ->sum('montant_total_ttc');

        return [
            Stat::make('Chantiers en Exécution', $chantiersActifs)
                ->description('Sur 3 villes du Royaume')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('success'),

            Stat::make('Effectif Ouvriers Actifs', $totalOuvriers)
                ->description('Permanents & Journaliers')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Demandes d\'Achat à Valider', $daEnAttente)
                ->description('En attente Conducteur ou DG')
                ->descriptionIcon('heroicon-m-clock')
                ->color($daEnAttente > 0 ? 'warning' : 'gray'),

            Stat::make('Engagements Achats (Mois)', number_format($commandesMois, 2, ',', ' ') . ' MAD')
                ->description('Total TTC Bons de Commande')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
