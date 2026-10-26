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
        // 1. Enrichissement de la table users
        Schema::table('users', function (Blueprint $table) {
            $table->string('cin', 20)->nullable()->after('email');
            $table->string('telephone', 25)->nullable()->after('cin');
            $table->string('fonction', 100)->nullable()->after('telephone');
            $table->boolean('is_active')->default(true)->after('fonction');
        });

        // 2. Villes du Maroc
        Schema::create('villes', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('region', 150)->nullable();
            $table->string('code_postal', 10)->nullable();
            $table->timestamps();
        });

        // 3. Chantiers
        Schema::create('chantiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ville_id')->constrained('villes')->cascadeOnDelete();
            $table->string('code', 50)->unique();
            $table->string('nom', 190);
            $table->string('client', 190)->nullable();
            $table->text('adresse')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedInteger('rayon_metres')->default(300);
            $table->decimal('budget_total', 15, 2)->default(0);
            $table->date('date_debut')->nullable();
            $table->date('date_fin_prevue')->nullable();
            $table->enum('statut', ['en_preparation', 'en_cours', 'en_pause', 'termine', 'cloture'])->default('en_cours');
            $table->timestamps();
        });

        // 4. Affectation Utilisateurs <-> Chantiers
        Schema::create('chantier_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chantier_id')->constrained('chantiers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role_sur_chantier', 50)->default('chef_de_chantier');
            $table->timestamps();
            $table->unique(['chantier_id', 'user_id', 'role_sur_chantier']);
        });

        // 5. Fournisseurs Matériaux BTP
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 190);
            $table->string('ice', 30)->nullable(); // Identifiant Commun Entreprise Maroc
            $table->string('ville', 100)->nullable();
            $table->text('adresse')->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('contact_nom', 100)->nullable();
            $table->string('rib', 40)->nullable();
            $table->timestamps();
        });

        // 6. Catalogue d'Articles & Matériaux courants
        Schema::create('articles_catalogue', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->nullable();
            $table->string('designation', 190);
            $table->string('categorie', 100)->default('Gros Œuvre');
            $table->string('unite', 30)->default('Unité'); // Sac, Tonne, m3, Barre, m2, Litre
            $table->decimal('prix_indicatif_ht', 12, 2)->nullable();
            $table->timestamps();
        });

        // 7. Demandes d'Achat (DA)
        Schema::create('demandes_achat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chantier_id')->constrained('chantiers')->cascadeOnDelete();
            $table->foreignId('demandeur_id')->constrained('users')->cascadeOnDelete();
            $table->string('numero_da', 50)->unique();
            $table->enum('urgence', ['normal', 'urgent', 'bloquant'])->default('normal');
            $table->enum('statut', [
                'brouillon',
                'en_attente_conducteur',
                'valide_conducteur',
                'en_cours_chiffrage',
                'en_attente_dg',
                'approuve',
                'rejete',
                'commande',
                'livre_partiel',
                'livre_total'
            ])->default('en_attente_conducteur');
            $table->text('motif')->nullable();
            $table->date('date_besoin')->nullable();
            $table->string('justificatif_photo_path')->nullable();
            $table->decimal('montant_estime_total_ht', 15, 2)->default(0);
            $table->foreignId('conducteur_valideur_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('date_validation_conducteur')->nullable();
            $table->foreignId('dg_valideur_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('date_validation_dg')->nullable();
            $table->text('motif_rejet')->nullable();
            $table->timestamps();
        });

        // 8. Lignes de la Demande d'Achat
        Schema::create('lignes_achat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_achat_id')->constrained('demandes_achat')->cascadeOnDelete();
            $table->foreignId('article_id')->nullable()->constrained('articles_catalogue')->nullOnDelete();
            $table->string('designation', 190);
            $table->string('unite', 30);
            $table->decimal('quantite_demandee', 12, 2);
            $table->decimal('quantite_commandee', 12, 2)->default(0);
            $table->decimal('quantite_recue', 12, 2)->default(0);
            $table->decimal('prix_unitaire_estime', 12, 2)->nullable();
            $table->decimal('prix_unitaire_negocie_ht', 12, 2)->nullable();
            $table->text('remarques')->nullable();
            $table->timestamps();
        });

        // 9. Bons de Commande (BC)
        Schema::create('bons_commande', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demande_achat_id')->constrained('demandes_achat')->cascadeOnDelete();
            $table->foreignId('fournisseur_id')->constrained('fournisseurs')->cascadeOnDelete();
            $table->foreignId('cree_par_id')->constrained('users')->cascadeOnDelete();
            $table->string('numero_bc', 50)->unique();
            $table->date('date_commande');
            $table->date('delai_livraison_prevu')->nullable();
            $table->string('conditions_paiement', 100)->nullable();
            $table->decimal('montant_total_ht', 15, 2)->default(0);
            $table->decimal('taux_tva', 5, 2)->default(20.00); // Taux normal TVA au Maroc = 20%
            $table->decimal('montant_tva', 15, 2)->default(0);
            $table->decimal('montant_total_ttc', 15, 2)->default(0);
            $table->enum('statut', ['emis', 'confirme_fournisseur', 'en_livraison', 'solde', 'annule'])->default('emis');
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });

        // 10. Réceptions de Livraison sur Chantier (BL)
        Schema::create('receptions_bl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_commande_id')->constrained('bons_commande')->cascadeOnDelete();
            $table->foreignId('chantier_id')->constrained('chantiers')->cascadeOnDelete();
            $table->foreignId('receptionnaire_id')->constrained('users')->cascadeOnDelete();
            $table->string('numero_bl_fournisseur', 100);
            $table->dateTime('date_reception');
            $table->string('photo_bl_path')->nullable();
            $table->enum('statut_conformite', ['conforme', 'partiel', 'non_conforme_avarie'])->default('conforme');
            $table->text('observations')->nullable();
            $table->timestamps();
        });

        // 11. Détails des Réceptions (Lignes reçues)
        Schema::create('lignes_reception', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reception_bl_id')->constrained('receptions_bl')->cascadeOnDelete();
            $table->foreignId('ligne_achat_id')->constrained('lignes_achat')->cascadeOnDelete();
            $table->decimal('quantite_recue', 12, 2);
            $table->boolean('conforme')->default(true);
            $table->string('motif_ecart')->nullable();
            $table->timestamps();
        });

        // 12. Employés & Ouvriers de Chantier
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('matricule', 50)->unique();
            $table->string('cin', 20)->nullable();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->string('telephone', 30)->nullable();
            $table->enum('specialite', [
                'chef_equipe',
                'macon',
                'ferrailleur',
                'coffreur',
                'grutier',
                'conducteur_engin',
                'electricien',
                'plombier',
                'peintre',
                'platrier',
                'carreleur',
                'manoeuvre',
                'gardien',
                'autre'
            ])->default('manoeuvre');
            $table->enum('type_contrat', ['permanent_cnss', 'journalier_tacheron', 'sous_traitant'])->default('journalier_tacheron');
            $table->decimal('cout_journalier_mad', 10, 2)->default(150.00);
            $table->foreignId('chantier_actuel_id')->nullable()->constrained('chantiers')->nullOnDelete();
            $table->boolean('is_actif')->default(true);
            $table->timestamps();
        });

        // 13. Pointages Quotidiens
        Schema::create('pointages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chantier_id')->constrained('chantiers')->cascadeOnDelete();
            $table->foreignId('employe_id')->constrained('employes')->cascadeOnDelete();
            $table->foreignId('pointeur_id')->constrained('users')->cascadeOnDelete();
            $table->date('date_pointage');
            $table->enum('statut_presence', [
                'present',
                'demi_journee',
                'absent_injustifie',
                'absent_justifie',
                'conge',
                'accident_travail'
            ])->default('present');
            $table->decimal('heures_normales', 4, 1)->default(8.0);
            $table->decimal('heures_sup', 4, 1)->default(0.0);
            $table->decimal('latitude_pointage', 10, 7)->nullable();
            $table->decimal('longitude_pointage', 10, 7)->nullable();
            $table->boolean('is_geoloc_valide')->default(true);
            $table->foreignId('valide_par_conducteur_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('date_validation_conducteur')->nullable();
            $table->string('remarques', 255)->nullable();
            $table->timestamps();

            // Un seul pointage par ouvrier par chantier et par date
            $table->unique(['chantier_id', 'employe_id', 'date_pointage'], 'unique_pointage_jour');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pointages');
        Schema::dropIfExists('employes');
        Schema::dropIfExists('lignes_reception');
        Schema::dropIfExists('receptions_bl');
        Schema::dropIfExists('bons_commande');
        Schema::dropIfExists('lignes_achat');
        Schema::dropIfExists('demandes_achat');
        Schema::dropIfExists('articles_catalogue');
        Schema::dropIfExists('fournisseurs');
        Schema::dropIfExists('chantier_user');
        Schema::dropIfExists('chantiers');
        Schema::dropIfExists('villes');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cin', 'telephone', 'fonction', 'is_active']);
        });
    }
};
