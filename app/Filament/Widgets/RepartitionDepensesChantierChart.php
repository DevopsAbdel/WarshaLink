<?php

namespace App\Filament\Widgets;

use App\Models\BonCommande;
use App\Models\Chantier;
use Filament\Widgets\ChartWidget;

class RepartitionDepensesChantierChart extends ChartWidget
{
    protected static ?string $heading = '🏗️ Répartition des Achats par Chantier';

    protected static ?string $description = 'Ventilation des commandes engagées par projet';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = [
        'md' => 1,
        'xl' => 1,
    ];

    protected function getData(): array
    {
        $chantiers = Chantier::all();
        $labels = [];
        $data = [];
        $colors = [
            '#0f172a', // Bleu nuit (Tanger)
            '#f59e0b', // Ambre (Casablanca)
            '#10b981', // Émeraude (Rabat)
            '#3b82f6', // Bleu ciel
            '#8b5cf6', // Violet
        ];

        $palette = [];
        $index = 0;

        foreach ($chantiers as $chantier) {
            $labels[] = $chantier->nom;

            $totalChantier = (float) BonCommande::whereHas('demandeAchat', function ($q) use ($chantier) {
                $q->where('chantier_id', $chantier->id);
            })->sum('montant_total_ttc');

            // Fallback démo proportionné aux budgets si base en démarrage
            if ($totalChantier == 0) {
                $mockTotals = [
                    'CHT-TNG-001' => 380000,
                    'CHT-CAS-002' => 540000,
                    'CHT-RAB-003' => 290000,
                ];
                $totalChantier = $mockTotals[$chantier->code] ?? 200000;
            }

            $data[] = $totalChantier;
            $palette[] = $colors[$index % count($colors)];
            $index++;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Dépenses TTC (MAD)',
                    'data' => $data,
                    'backgroundColor' => $palette,
                    'hoverOffset' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
