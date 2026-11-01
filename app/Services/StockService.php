<?php

namespace App\Services;

use App\Models\MouvementStock;
use App\Models\ReceptionBl;
use App\Models\Stock;
use Exception;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * Enregistre une entrée de stock pour un chantier et un article donnés.
     */
    public function enregistrerEntree(
        int $chantierId,
        int $articleId,
        float $quantite,
        int $userId,
        string $type = 'entree_livraison',
        ?int $receptionBlId = null,
        ?string $motif = null
    ): MouvementStock {
        return DB::transaction(function () use ($chantierId, $articleId, $quantite, $userId, $type, $receptionBlId, $motif) {
            $stock = Stock::firstOrCreate(
                [
                    'chantier_id' => $chantierId,
                    'article_id' => $articleId,
                ],
                [
                    'quantite_actuelle' => 0.00,
                    'seuil_alerte_min' => 10.00,
                    'emplacement' => 'Magasin Chantier',
                ]
            );

            $avant = (float) $stock->quantite_actuelle;
            $apres = $avant + $quantite;

            $stock->quantite_actuelle = $apres;
            $stock->derniere_entree_at = now();
            $stock->save();

            return MouvementStock::create([
                'type_mouvement' => $type,
                'article_id' => $articleId,
                'chantier_destination_id' => $chantierId,
                'quantite' => $quantite,
                'quantite_avant' => $avant,
                'quantite_apres' => $apres,
                'reception_bl_id' => $receptionBlId,
                'auteur_id' => $userId,
                'motif_usage' => $motif ?? 'Entrée de stock',
                'date_mouvement' => now(),
            ]);
        });
    }

    /**
     * Enregistre une sortie de stock (consommation dans l'ouvrage, casse ou perte).
     * Empêche strictement les stocks négatifs si demandé.
     */
    public function enregistrerSortie(
        int $chantierId,
        int $articleId,
        float $quantite,
        int $userId,
        string $type = 'sortie_consommation',
        ?string $motif = null,
        ?string $lot = null,
        bool $autoriserNegatif = false
    ): MouvementStock {
        return DB::transaction(function () use ($chantierId, $articleId, $quantite, $userId, $type, $motif, $lot, $autoriserNegatif) {
            $stock = Stock::where('chantier_id', $chantierId)
                ->where('article_id', $articleId)
                ->first();

            $avant = $stock ? (float) $stock->quantite_actuelle : 0.00;

            if (!$autoriserNegatif && $avant < $quantite) {
                throw new Exception("Stock insuffisant sur le chantier. Disponible : {$avant}, Demandé : {$quantite}");
            }

            $apres = $avant - $quantite;

            if (!$stock) {
                $stock = new Stock([
                    'chantier_id' => $chantierId,
                    'article_id' => $articleId,
                    'seuil_alerte_min' => 10.00,
                    'emplacement' => 'Magasin Chantier',
                ]);
            }

            $stock->quantite_actuelle = $apres;
            $stock->derniere_sortie_at = now();
            $stock->save();

            return MouvementStock::create([
                'type_mouvement' => $type,
                'article_id' => $articleId,
                'chantier_source_id' => $chantierId,
                'quantite' => $quantite,
                'quantite_avant' => $avant,
                'quantite_apres' => $apres,
                'auteur_id' => $userId,
                'motif_usage' => $motif ?? 'Sortie pour exécution travaux',
                'lot_ouvrage' => $lot,
                'date_mouvement' => now(),
            ]);
        });
    }

    /**
     * Enregistre un transfert de matériel entre deux chantiers.
     */
    public function enregistrerTransfert(
        int $sourceChantierId,
        int $destChantierId,
        int $articleId,
        float $quantite,
        int $userId,
        ?string $motif = null
    ): MouvementStock {
        if ($sourceChantierId === $destChantierId) {
            throw new Exception("Le chantier de départ et le chantier d'arrivée doivent être différents.");
        }

        return DB::transaction(function () use ($sourceChantierId, $destChantierId, $articleId, $quantite, $userId, $motif) {
            // 1. Décrémenter la source
            $stockSource = Stock::where('chantier_id', $sourceChantierId)
                ->where('article_id', $articleId)
                ->first();

            $sourceAvant = $stockSource ? (float) $stockSource->quantite_actuelle : 0.00;

            if ($sourceAvant < $quantite) {
                throw new Exception("Stock insuffisant sur le chantier source. Disponible : {$sourceAvant}, À transférer : {$quantite}");
            }

            $sourceApres = $sourceAvant - $quantite;
            $stockSource->quantite_actuelle = $sourceApres;
            $stockSource->derniere_sortie_at = now();
            $stockSource->save();

            // 2. Incrémenter la destination
            $stockDest = Stock::firstOrCreate(
                [
                    'chantier_id' => $destChantierId,
                    'article_id' => $articleId,
                ],
                [
                    'quantite_actuelle' => 0.00,
                    'seuil_alerte_min' => 10.00,
                    'emplacement' => 'Magasin Chantier',
                ]
            );

            $destAvant = (float) $stockDest->quantite_actuelle;
            $destApres = $destAvant + $quantite;
            $stockDest->quantite_actuelle = $destApres;
            $stockDest->derniere_entree_at = now();
            $stockDest->save();

            // 3. Mouvement unique de transfert
            return MouvementStock::create([
                'type_mouvement' => 'transfert_inter_chantier',
                'article_id' => $articleId,
                'chantier_source_id' => $sourceChantierId,
                'chantier_destination_id' => $destChantierId,
                'quantite' => $quantite,
                'quantite_avant' => $sourceAvant,
                'quantite_apres' => $sourceApres,
                'auteur_id' => $userId,
                'motif_usage' => $motif ?? 'Transfert inter-chantiers',
                'date_mouvement' => now(),
            ]);
        });
    }

    /**
     * Ajustement d'inventaire suite à comptage physique / inventaire de fin de mois.
     */
    public function ajusterInventaire(
        int $chantierId,
        int $articleId,
        float $nouvelleQuantite,
        int $userId,
        string $justification
    ): MouvementStock {
        return DB::transaction(function () use ($chantierId, $articleId, $nouvelleQuantite, $userId, $justification) {
            $stock = Stock::firstOrCreate(
                [
                    'chantier_id' => $chantierId,
                    'article_id' => $articleId,
                ],
                [
                    'quantite_actuelle' => 0.00,
                    'seuil_alerte_min' => 10.00,
                    'emplacement' => 'Magasin Chantier',
                ]
            );

            $avant = (float) $stock->quantite_actuelle;
            $difference = $nouvelleQuantite - $avant;

            $stock->quantite_actuelle = $nouvelleQuantite;
            if ($difference >= 0) {
                $stock->derniere_entree_at = now();
            } else {
                $stock->derniere_sortie_at = now();
            }
            $stock->save();

            return MouvementStock::create([
                'type_mouvement' => 'ajustement_inventaire',
                'article_id' => $articleId,
                'chantier_destination_id' => $chantierId,
                'quantite' => abs($difference),
                'quantite_avant' => $avant,
                'quantite_apres' => $nouvelleQuantite,
                'auteur_id' => $userId,
                'motif_usage' => "Ajustement inventaire : {$justification} (" . ($difference >= 0 ? "+{$difference}" : "{$difference}") . ")",
                'date_mouvement' => now(),
            ]);
        });
    }

    /**
     * Synchronise les stocks à partir d'un Bon de Livraison reçu.
     */
    public function syncReceptionBl(ReceptionBl $reception): void
    {
        $reception->load(['lignes.ligneAchat', 'chantier']);

        foreach ($reception->lignes as $ligne) {
            $articleId = $ligne->ligneAchat?->article_id;
            $quantite = (float) $ligne->quantite_recue;

            if ($articleId && $quantite > 0) {
                $this->enregistrerEntree(
                    chantierId: $reception->chantier_id,
                    articleId: $articleId,
                    quantite: $quantite,
                    userId: $reception->receptionnaire_id ?? auth()->id() ?? 1,
                    type: 'entree_livraison',
                    receptionBlId: $reception->id,
                    motif: "Réception BL n° {$reception->numero_bl_fournisseur}"
                );
            }
        }
    }
}
