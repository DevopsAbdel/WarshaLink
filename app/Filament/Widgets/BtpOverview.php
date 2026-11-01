<?php

namespace App\Filament\Widgets;

use App\Models\BonCommande;
use App\Models\Chantier;
use App\Models\DemandeAchat;
use App\Models\Employe;
use App\Models\Pointage;
use App\Models\Stock;
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

        // 1. Valeur globale des stocks en magasin
        $valeurStock = Stock::with('article')->get()->sum(function ($s) {
            return (float) $s->quantite_actuelle * (float) ($s->article?->prix_indicatif_ht ?? 0);
        });

        // 2. Taux de présence du jour
        $pointagesAujourdhui = Pointage::whereDate('date_pointage', now()->toDateString())->get();
        $nbPresents = $pointagesAujourdhui->where('statut_presence', 'present')->count();
        $tauxPresence = $totalOuvriers > 0 ? round(($nbPresents / $totalOuvriers) * 100, 1) : 0;

        return [
            Stat::make('Chantiers en Exécution', $chantiersActifs)
                ->description('Sur 3 villes du Royaume')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('success'),

            Stat::make('Effectif Ouvriers Actifs', $totalOuvriers)
                ->description('Permanents & Journaliers')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Présence Terrain Aujourd\'hui', "{$tauxPresence} %")
                ->description("{$nbPresents} ouvriers pointés présents")
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($tauxPresence >= 80 ? 'success' : 'warning'),

            Stat::make('Demandes d\'Achat à Valider', $daEnAttente)
                ->description('En attente Conducteur ou DG')
                ->descriptionIcon('heroicon-m-clock')
                ->color($daEnAttente > 0 ? 'warning' : 'gray'),

            Stat::make('Valeur Stocks Magasins', number_format($valeurStock, 2, ',', ' ') . ' MAD')
                ->description('Matériaux disponibles')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('info'),

            Stat::make('Engagements Achats (Mois)', number_format($commandesMois, 2, ',', ' ') . ' MAD')
                ->description('Total TTC Bons de Commande')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),
        ];
    }
}
