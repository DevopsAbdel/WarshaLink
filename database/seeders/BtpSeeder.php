<?php

namespace Database\Seeders;

use App\Models\ArticleCatalogue;
use App\Models\BonCommande;
use App\Models\Chantier;
use App\Models\DemandeAchat;
use App\Models\Employe;
use App\Models\Fournisseur;
use App\Models\LigneAchat;
use App\Models\Pointage;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class BtpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Rôles et Permissions
        $roles = [
            'direction_generale' => 'Direction Générale & DAF',
            'conducteur_travaux' => 'Conducteur de Travaux',
            'chef_chantier' => 'Chef de Chantier',
            'responsable_achats' => 'Responsable Achats & Logistique',
            'responsable_rh' => 'Responsable Ressources Humaines & Paie',
        ];

        foreach ($roles as $name => $label) {
            Role::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // 2. Utilisateurs de démonstration
        $usersData = [
            [
                'name' => 'Directeur Général (M. Karim Bennani)',
                'email' => 'direction@btpmaroc.ma',
                'cin' => 'BE458921',
                'telephone' => '0661123456',
                'fonction' => 'Directeur Général',
                'role' => 'direction_generale',
            ],
            [
                'name' => 'Ing. Mehdi Alami (Conducteur Travaux)',
                'email' => 'conducteur@btpmaroc.ma',
                'cin' => 'K342110',
                'telephone' => '0662234567',
                'fonction' => 'Conducteur Principal de Travaux',
                'role' => 'conducteur_travaux',
            ],
            [
                'name' => 'Chef Hassan Toumi (Chantier Tanger)',
                'email' => 'chef.tanger@btpmaroc.ma',
                'cin' => 'L567890',
                'telephone' => '0663345678',
                'fonction' => 'Chef de Chantier Tanger',
                'role' => 'chef_chantier',
            ],
            [
                'name' => 'Chef Youssef Radi (Chantier Casa)',
                'email' => 'chef.casa@btpmaroc.ma',
                'cin' => 'BK789012',
                'telephone' => '0664456789',
                'fonction' => 'Chef de Chantier Casablanca',
                'role' => 'chef_chantier',
            ],
            [
                'name' => 'Mme Sanae Fassi (Achats)',
                'email' => 'achats@btpmaroc.ma',
                'cin' => 'A123456',
                'telephone' => '0665567890',
                'fonction' => 'Responsable Achats & Approvisionnements',
                'role' => 'responsable_achats',
            ],
            [
                'name' => 'M. Rachid Idrissi (RH & Paie)',
                'email' => 'rh@btpmaroc.ma',
                'cin' => 'D987654',
                'telephone' => '0666678901',
                'fonction' => 'Responsable RH & Gestion Paie',
                'role' => 'responsable_rh',
            ],
        ];

        $users = [];
        foreach ($usersData as $userData) {
            $role = $userData['role'];
            unset($userData['role']);
            $userData['password'] = Hash::make('password');
            $userData['is_active'] = true;

            $user = User::updateOrCreate(['email' => $userData['email']], $userData);
            $user->syncRoles([$role]);
            $users[$role] = $user;
        }

        // 3. Villes du Maroc
        $villesData = [
            ['nom' => 'Casablanca', 'region' => 'Casablanca-Settat', 'code_postal' => '20000'],
            ['nom' => 'Rabat', 'region' => 'Rabat-Salé-Kénitra', 'code_postal' => '10000'],
            ['nom' => 'Tanger', 'region' => 'Tanger-Tétouan-Al Hoceïma', 'code_postal' => '90000'],
            ['nom' => 'Marrakech', 'region' => 'Marrakech-Safi', 'code_postal' => '40000'],
            ['nom' => 'Agadir', 'region' => 'Souss-Massa', 'code_postal' => '80000'],
            ['nom' => 'Fès', 'region' => 'Fès-Meknès', 'code_postal' => '30000'],
        ];

        $villes = [];
        foreach ($villesData as $v) {
            $villes[$v['nom']] = Ville::firstOrCreate(['nom' => $v['nom']], $v);
        }

        // 4. Chantiers
        $chantiersData = [
            [
                'ville_id' => $villes['Tanger']->id,
                'code' => 'CHT-TNG-001',
                'nom' => 'Tour Marina Bay Tanger',
                'client' => 'TMSA / Tanger Med',
                'adresse' => 'Zone Portuaire & Marina de Tanger',
                'latitude' => 35.7891234,
                'longitude' => -5.8123456,
                'rayon_metres' => 400,
                'budget_total' => 4500000.00,
                'date_debut' => '2026-01-15',
                'date_fin_prevue' => '2027-06-30',
                'statut' => 'en_cours',
            ],
            [
                'ville_id' => $villes['Casablanca']->id,
                'code' => 'CHT-CAS-002',
                'nom' => 'Résidence Les Palmiers Oasis',
                'client' => 'Groupe Immobilier Al Omrane',
                'adresse' => 'Boulevard Ghandi, Casablanca',
                'latitude' => 33.5731104,
                'longitude' => -7.6498522,
                'rayon_metres' => 300,
                'budget_total' => 8200000.00,
                'date_debut' => '2026-02-01',
                'date_fin_prevue' => '2027-12-31',
                'statut' => 'en_cours',
            ],
            [
                'ville_id' => $villes['Rabat']->id,
                'code' => 'CHT-RAB-003',
                'nom' => 'Complexe Bureaux Hay Riad Tech',
                'client' => 'CGI Développement',
                'adresse' => 'Avenue Annakhil, Hay Riad, Rabat',
                'latitude' => 33.9685023,
                'longitude' => -6.8791245,
                'rayon_metres' => 350,
                'budget_total' => 12000000.00,
                'date_debut' => '2026-03-10',
                'date_fin_prevue' => '2028-03-31',
                'statut' => 'en_cours',
            ],
        ];

        $chantiers = [];
        foreach ($chantiersData as $c) {
            $chantier = Chantier::firstOrCreate(['code' => $c['code']], $c);
            $chantiers[$c['code']] = $chantier;
        }

        // Affectations
        $conducteur = User::where('email', 'conducteur@btpmaroc.ma')->first();
        if ($conducteur) {
            foreach ($chantiers as $ch) {
                $ch->users()->syncWithoutDetaching([$conducteur->id => ['role_sur_chantier' => 'conducteur']]);
            }
        }

        $chefTanger = User::where('email', 'chef.tanger@btpmaroc.ma')->first();
        if ($chefTanger && isset($chantiers['CHT-TNG-001'])) {
            $chantiers['CHT-TNG-001']->users()->syncWithoutDetaching([$chefTanger->id => ['role_sur_chantier' => 'chef_de_chantier']]);
        }

        $chefCasa = User::where('email', 'chef.casa@btpmaroc.ma')->first();
        if ($chefCasa && isset($chantiers['CHT-CAS-002'])) {
            $chantiers['CHT-CAS-002']->users()->syncWithoutDetaching([$chefCasa->id => ['role_sur_chantier' => 'chef_de_chantier']]);
        }

        // 5. Fournisseurs BTP Maroc
        $fournisseursData = [
            [
                'nom' => 'LafargeHolcim Maroc S.A.',
                'ice' => '000012345000088',
                'ville' => 'Casablanca',
                'adresse' => '6 boulevard de la Corniche, Casablanca',
                'telephone' => '0522956789',
                'email' => 'commandes@lafargeholcim.ma',
                'contact_nom' => 'M. Mohamed Cherkaoui',
                'rib' => '011780000012345678901234',
            ],
            [
                'nom' => 'Ciments du Maroc (Heidelberg Materials)',
                'ice' => '001567890000077',
                'ville' => 'Casablanca',
                'adresse' => '621 boulevard Panoramique, Casablanca',
                'telephone' => '0522854000',
                'email' => 'ventes@cimar.co.ma',
                'contact_nom' => 'Mme Salma Tazi',
                'rib' => '022780000045678901234567',
            ],
            [
                'nom' => 'Comptoir Métallurgique Marocain (Aciers & Fer)',
                'ice' => '001890123000066',
                'ville' => 'Tanger',
                'adresse' => 'Zone Industrielle Moghogha, Tanger',
                'telephone' => '0539352000',
                'email' => 'tanger.acier@comptoir-metal.ma',
                'contact_nom' => 'M. Tarik Berrada',
                'rib' => '007780000098765432109876',
            ],
            [
                'nom' => 'Briqueterie Salam Tanger',
                'ice' => '002345678000055',
                'ville' => 'Tanger',
                'adresse' => 'Route de Rabat km 12, Tanger',
                'telephone' => '0539394545',
                'email' => 'contact@briqueteriesalam.ma',
                'contact_nom' => 'M. Omar Kabbaj',
                'rib' => '013780000011223344556677',
            ],
        ];

        $fournisseurs = [];
        foreach ($fournisseursData as $f) {
            $fournisseurs[$f['nom']] = Fournisseur::firstOrCreate(['nom' => $f['nom']], $f);
        }

        // 6. Catalogue d'Articles & Matériaux
        $articlesData = [
            ['code' => 'CIM-CPJ45', 'designation' => 'Ciment CPJ 45 (Sac de 50 kg)', 'categorie' => 'Gros Œuvre', 'unite' => 'Sac', 'prix_indicatif_ht' => 78.50],
            ['code' => 'CIM-CPJ35', 'designation' => 'Ciment CPJ 35 (Sac de 50 kg)', 'categorie' => 'Gros Œuvre', 'unite' => 'Sac', 'prix_indicatif_ht' => 69.00],
            ['code' => 'SAB-CONC', 'designation' => 'Sable de concassage lavé 0/4', 'categorie' => 'Granulats', 'unite' => 'm3', 'prix_indicatif_ht' => 180.00],
            ['code' => 'GRAV-1525', 'designation' => 'Gravette G1 calibre 15/25', 'categorie' => 'Granulats', 'unite' => 'm3', 'prix_indicatif_ht' => 195.00],
            ['code' => 'FER-T12', 'designation' => 'Rond à Béton Haute Adhérence FeE500 Diam 12mm', 'categorie' => 'Ferraillage', 'unite' => 'Tonne', 'prix_indicatif_ht' => 8900.00],
            ['code' => 'FER-T10', 'designation' => 'Rond à Béton Haute Adhérence FeE500 Diam 10mm', 'categorie' => 'Ferraillage', 'unite' => 'Tonne', 'prix_indicatif_ht' => 8950.00],
            ['code' => 'FER-T8', 'designation' => 'Rond à Béton Haute Adhérence FeE500 Diam 8mm', 'categorie' => 'Ferraillage', 'unite' => 'Tonne', 'prix_indicatif_ht' => 9100.00],
            ['code' => 'BRIQ-8T', 'designation' => 'Briques rouges en terre cuite 8 trous', 'categorie' => 'Maçonnerie', 'unite' => 'Mille', 'prix_indicatif_ht' => 2400.00],
            ['code' => 'HOURD-16', 'designation' => 'Hourdis béton hauteur 16 cm pour plancher', 'categorie' => 'Planchers', 'unite' => 'Mille', 'prix_indicatif_ht' => 5200.00],
            ['code' => 'PVC-160', 'designation' => 'Tube PVC assainissement CR4 Diamètre 160mm (4m)', 'categorie' => 'Plomberie & VRD', 'unite' => 'Barre', 'prix_indicatif_ht' => 165.00],
            ['code' => 'GAINE-ICTA', 'designation' => 'Gaine ICTA Diamètre 20mm (Couronne 100m)', 'categorie' => 'Électricité', 'unite' => 'Couronne', 'prix_indicatif_ht' => 220.00],
        ];

        $articles = [];
        foreach ($articlesData as $art) {
            $articles[$art['code']] = ArticleCatalogue::firstOrCreate(['code' => $art['code']], $art);
        }

        // 7. Ouvriers et Personnel de Chantier
        $employesData = [
            // Chantier Tanger
            ['matricule' => 'EMP-TNG-01', 'cin' => 'L234123', 'nom' => 'El Ouardi', 'prenom' => 'Abdellah', 'specialite' => 'chef_equipe', 'type_contrat' => 'permanent_cnss', 'cout_journalier_mad' => 250.00, 'chantier' => 'CHT-TNG-001'],
            ['matricule' => 'EMP-TNG-02', 'cin' => 'L892341', 'nom' => 'Benali', 'prenom' => 'Mustapha', 'specialite' => 'macon', 'type_contrat' => 'journalier_tacheron', 'cout_journalier_mad' => 180.00, 'chantier' => 'CHT-TNG-001'],
            ['matricule' => 'EMP-TNG-03', 'cin' => 'L671239', 'nom' => 'Chafik', 'prenom' => 'Noureddine', 'specialite' => 'ferrailleur', 'type_contrat' => 'journalier_tacheron', 'cout_journalier_mad' => 190.00, 'chantier' => 'CHT-TNG-001'],
            ['matricule' => 'EMP-TNG-04', 'cin' => 'L345671', 'nom' => 'Tahiri', 'prenom' => 'Said', 'specialite' => 'coffreur', 'type_contrat' => 'journalier_tacheron', 'cout_journalier_mad' => 180.00, 'chantier' => 'CHT-TNG-001'],
            ['matricule' => 'EMP-TNG-05', 'cin' => 'L901234', 'nom' => 'Zouhairi', 'prenom' => 'Hamza', 'specialite' => 'grutier', 'type_contrat' => 'permanent_cnss', 'cout_journalier_mad' => 280.00, 'chantier' => 'CHT-TNG-001'],
            ['matricule' => 'EMP-TNG-06', 'cin' => 'L112233', 'nom' => 'Amrani', 'prenom' => 'Khalid', 'specialite' => 'manoeuvre', 'type_contrat' => 'journalier_tacheron', 'cout_journalier_mad' => 130.00, 'chantier' => 'CHT-TNG-001'],
            ['matricule' => 'EMP-TNG-07', 'cin' => 'L445566', 'nom' => 'Mansouri', 'prenom' => 'Jamal', 'specialite' => 'manoeuvre', 'type_contrat' => 'journalier_tacheron', 'cout_journalier_mad' => 130.00, 'chantier' => 'CHT-TNG-001'],

            // Chantier Casablanca
            ['matricule' => 'EMP-CAS-01', 'cin' => 'BK334455', 'nom' => 'Daoudi', 'prenom' => 'Brahim', 'specialite' => 'chef_equipe', 'type_contrat' => 'permanent_cnss', 'cout_journalier_mad' => 260.00, 'chantier' => 'CHT-CAS-002'],
            ['matricule' => 'EMP-CAS-02', 'cin' => 'BK667788', 'nom' => 'Kaddouri', 'prenom' => 'Aziz', 'specialite' => 'macon', 'type_contrat' => 'journalier_tacheron', 'cout_journalier_mad' => 180.00, 'chantier' => 'CHT-CAS-002'],
            ['matricule' => 'EMP-CAS-03', 'cin' => 'BK990011', 'nom' => 'Sabir', 'prenom' => 'Reda', 'specialite' => 'ferrailleur', 'type_contrat' => 'journalier_tacheron', 'cout_journalier_mad' => 190.00, 'chantier' => 'CHT-CAS-002'],
            ['matricule' => 'EMP-CAS-04', 'cin' => 'BK223344', 'nom' => 'El Moumni', 'prenom' => 'Ayoub', 'specialite' => 'electricien', 'type_contrat' => 'sous_traitant', 'cout_journalier_mad' => 220.00, 'chantier' => 'CHT-CAS-002'],
            ['matricule' => 'EMP-CAS-05', 'cin' => 'BK556677', 'nom' => 'Belhaj', 'prenom' => 'Hicham', 'specialite' => 'plombier', 'type_contrat' => 'sous_traitant', 'cout_journalier_mad' => 210.00, 'chantier' => 'CHT-CAS-002'],
            ['matricule' => 'EMP-CAS-06', 'cin' => 'BK889900', 'nom' => 'Qasmi', 'prenom' => 'Anas', 'specialite' => 'manoeuvre', 'type_contrat' => 'journalier_tacheron', 'cout_journalier_mad' => 130.00, 'chantier' => 'CHT-CAS-002'],
        ];

        $employes = [];
        foreach ($employesData as $emp) {
            $chantierCode = $emp['chantier'];
            unset($emp['chantier']);
            $emp['chantier_actuel_id'] = $chantiers[$chantierCode]->id ?? null;
            $emp['is_actif'] = true;
            $employes[$emp['matricule']] = Employe::firstOrCreate(['matricule' => $emp['matricule']], $emp);
        }

        // 8. Demandes d'Achat Réelles (Exemples)
        // DA 1 : Chantier Tanger -> Validée et Commandée
        $da1 = DemandeAchat::firstOrCreate(
            ['numero_da' => 'DA-2026-0001'],
            [
                'chantier_id' => $chantiers['CHT-TNG-001']->id,
                'demandeur_id' => $chefTanger->id ?? 1,
                'urgence' => 'urgent',
                'statut' => 'commande',
                'motif' => 'Coulage des voiles périphériques sous-sol R-2 (Phase urgente avant pluie)',
                'date_besoin' => now()->addDays(2),
                'montant_estime_total_ht' => 21725.00,
                'conducteur_valideur_id' => $conducteur->id ?? 1,
                'date_validation_conducteur' => now()->subDay(),
                'dg_valideur_id' => $users['direction_generale']->id ?? 1,
                'date_validation_dg' => now()->subHours(12),
            ]
        );

        LigneAchat::firstOrCreate(
            ['demande_achat_id' => $da1->id, 'designation' => 'Ciment CPJ 45 (Sac de 50 kg)'],
            [
                'article_id' => $articles['CIM-CPJ45']->id ?? null,
                'unite' => 'Sac',
                'quantite_demandee' => 100,
                'quantite_commandee' => 100,
                'prix_unitaire_estime' => 78.50,
                'prix_unitaire_negocie_ht' => 78.50,
                'remarques' => 'Marque LafargeHolcim certifiée',
            ]
        );

        LigneAchat::firstOrCreate(
            ['demande_achat_id' => $da1->id, 'designation' => 'Rond à Béton Haute Adhérence FeE500 Diam 12mm'],
            [
                'article_id' => $articles['FER-T12']->id ?? null,
                'unite' => 'Tonne',
                'quantite_demandee' => 1.5,
                'quantite_commandee' => 1.5,
                'prix_unitaire_estime' => 8900.00,
                'prix_unitaire_negocie_ht' => 8900.00,
                'remarques' => 'Longueurs standard 12m',
            ]
        );

        LigneAchat::firstOrCreate(
            ['demande_achat_id' => $da1->id, 'designation' => 'Sable de concassage lavé 0/4'],
            [
                'article_id' => $articles['SAB-CONC']->id ?? null,
                'unite' => 'm3',
                'quantite_demandee' => 3,
                'quantite_commandee' => 3,
                'prix_unitaire_estime' => 175.00,
                'prix_unitaire_negocie_ht' => 175.00,
                'remarques' => 'Livraison par camion benne',
            ]
        );

        // Bon de Commande correspondant
        $fournisseurLafarge = Fournisseur::where('nom', 'LIKE', '%LafargeHolcim%')->first();
        if ($fournisseurLafarge) {
            BonCommande::firstOrCreate(
                ['numero_bc' => 'BC-2026-0001'],
                [
                    'demande_achat_id' => $da1->id,
                    'fournisseur_id' => $fournisseurLafarge->id,
                    'cree_par_id' => $users['responsable_achats']->id ?? 1,
                    'date_commande' => now()->toDateString(),
                    'delai_livraison_prevu' => now()->addDays(2)->toDateString(),
                    'conditions_paiement' => '60 jours fin de mois par virement',
                    'montant_total_ht' => 21725.00,
                    'taux_tva' => 20.00,
                    'montant_tva' => 4345.00,
                    'montant_total_ttc' => 26070.00,
                    'statut' => 'emis',
                ]
            );
        }

        // DA 2 : Chantier Casa -> En attente de validation conducteur
        $da2 = DemandeAchat::firstOrCreate(
            ['numero_da' => 'DA-2026-0002'],
            [
                'chantier_id' => $chantiers['CHT-CAS-002']->id,
                'demandeur_id' => $chefCasa->id ?? 1,
                'urgence' => 'bloquant',
                'statut' => 'en_attente_conducteur',
                'motif' => 'Rupture de briques rouges pour cloisons 2ème étage',
                'date_besoin' => now()->addDay(),
                'montant_estime_total_ht' => 12000.00,
            ]
        );

        LigneAchat::firstOrCreate(
            ['demande_achat_id' => $da2->id, 'designation' => 'Briques rouges en terre cuite 8 trous'],
            [
                'article_id' => $articles['BRIQ-8T']->id ?? null,
                'unite' => 'Mille',
                'quantite_demandee' => 5,
                'quantite_commandee' => 0,
                'prix_unitaire_estime' => 2400.00,
                'remarques' => 'Premier choix sans casses',
            ]
        );

        // 9. Pointages Quotidiens Tanger
        $ouvriersTanger = Employe::where('chantier_actuel_id', $chantiers['CHT-TNG-001']->id)->get();
        foreach ($ouvriersTanger as $ouvrier) {
            Pointage::firstOrCreate(
                [
                    'chantier_id' => $chantiers['CHT-TNG-001']->id,
                    'employe_id' => $ouvrier->id,
                    'date_pointage' => now()->toDateString(),
                ],
                [
                    'pointeur_id' => $chefTanger->id ?? 1,
                    'statut_presence' => 'present',
                    'heures_normales' => 8.0,
                    'heures_sup' => ($ouvrier->specialite === 'grutier' ? 2.0 : 0.0),
                    'latitude_pointage' => 35.7891234,
                    'longitude_pointage' => -5.8123456,
                    'is_geoloc_valide' => true,
                    'valide_par_conducteur_id' => $conducteur->id ?? 1,
                    'date_validation_conducteur' => now(),
                ]
            );
        }
    }
}
