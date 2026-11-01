<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Table des Stocks par Chantier et par Article
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chantier_id')->constrained('chantiers')->cascadeOnDelete();
            $table->foreignId('article_id')->constrained('articles_catalogue')->cascadeOnDelete();
            $table->decimal('quantite_actuelle', 12, 2)->default(0.00);
            $table->decimal('seuil_alerte_min', 12, 2)->default(10.00);
            $table->string('emplacement', 100)->nullable(); // ex: Magasin Central, Parc Ferraillage, Conteneur 1
            $table->dateTime('derniere_entree_at')->nullable();
            $table->dateTime('derniere_sortie_at')->nullable();
            $table->timestamps();

            $table->unique(['chantier_id', 'article_id'], 'unique_stock_chantier_article');
        });

        // 2. Table des Mouvements de Stock (Traçabilité & Audit complet)
        Schema::create('mouvements_stock', function (Blueprint $table) {
            $table->id();
            $table->string('numero_mouvement', 50)->unique();
            $table->enum('type_mouvement', [
                'entree_livraison',
                'entree_retour_chantier',
                'sortie_consommation',
                'sortie_perte_casse',
                'transfert_inter_chantier',
                'ajustement_inventaire',
            ]);
            $table->foreignId('article_id')->constrained('articles_catalogue')->cascadeOnDelete();
            $table->foreignId('chantier_source_id')->nullable()->constrained('chantiers')->nullOnDelete();
            $table->foreignId('chantier_destination_id')->nullable()->constrained('chantiers')->nullOnDelete();
            $table->decimal('quantite', 12, 2);
            $table->decimal('quantite_avant', 12, 2)->nullable();
            $table->decimal('quantite_apres', 12, 2)->nullable();
            $table->foreignId('reception_bl_id')->nullable()->constrained('receptions_bl')->nullOnDelete();
            $table->foreignId('auteur_id')->constrained('users')->cascadeOnDelete();
            $table->string('motif_usage', 255)->nullable(); // ex: Coulage plancher R+2, Avarie pluie, etc.
            $table->string('lot_ouvrage', 100)->nullable(); // ex: Gros Œuvre, Électricité, Revêtement
            $table->dateTime('date_mouvement');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvements_stock');
        Schema::dropIfExists('stocks');
    }
};
