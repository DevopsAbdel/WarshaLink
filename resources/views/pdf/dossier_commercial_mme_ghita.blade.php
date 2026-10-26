<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dossier Stratégique & Offre Commerciale - Madame Ghita</title>
    <style>
        @page {
            margin: 12mm 15mm 15mm 15mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        /* En-tête & Pied de page fixes */
        .footer {
            position: fixed;
            bottom: -5mm;
            left: 0;
            right: 0;
            height: 10mm;
            border-top: 1px solid #cbd5e1;
            padding-top: 4px;
            font-size: 8.5px;
            color: #64748b;
            text-align: center;
        }
        .footer .left { float: left; width: 40%; text-align: left; }
        .footer .center { float: left; width: 30%; text-align: center; }
        .footer .right { float: right; width: 30%; text-align: right; }

        /* Sauts de page */
        .page-break {
            page-break-after: always;
        }

        /* Page de garde */
        .cover {
            text-align: center;
            padding-top: 40px;
        }
        .cover-tag {
            display: inline-block;
            background-color: #fef3c7;
            color: #b45309;
            font-weight: bold;
            font-size: 11px;
            padding: 6px 16px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid #fde68a;
            margin-bottom: 25px;
        }
        .cover-title {
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.25;
            margin-bottom: 12px;
            text-transform: uppercase;
        }
        .cover-title span {
            color: #d97706;
        }
        .cover-subtitle {
            font-size: 14px;
            color: #475569;
            max-width: 500px;
            margin: 0 auto 35px auto;
            line-height: 1.5;
        }
        .cover-divider {
            width: 80px;
            height: 4px;
            background-color: #d97706;
            margin: 0 auto 35px auto;
            border-radius: 2px;
        }
        .cover-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            width: 85%;
            margin: 0 auto;
            text-align: left;
        }
        .cover-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .cover-box td {
            padding: 8px 10px;
            font-size: 11px;
            border-bottom: 1px solid #f1f5f9;
        }
        .cover-box td.label {
            font-weight: bold;
            color: #64748b;
            width: 35%;
            text-transform: uppercase;
            font-size: 9.5px;
        }
        .cover-box td.val {
            color: #0f172a;
            font-weight: 600;
        }

        /* Titres de sections */
        h2.section-title {
            font-size: 16px;
            color: #0f172a;
            border-left: 4px solid #d97706;
            padding-left: 10px;
            margin-top: 15px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        h3.subsection-title {
            font-size: 12.5px;
            color: #1e3a8a;
            margin-top: 15px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        /* Blocs et Cartes */
        .card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px 14px;
            margin-bottom: 12px;
        }
        .card-highlight {
            background-color: #f8fafc;
            border-left: 4px solid #1e3a8a;
        }
        .card-amber {
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            border-left: 4px solid #d97706;
        }
        .card-green {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #16a34a;
        }

        /* Tableaux stylisés */
        table.styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
        }
        table.styled-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 10px;
            font-weight: 600;
            text-align: left;
            padding: 7px 10px;
            text-transform: uppercase;
        }
        table.styled-table td {
            border: 1px solid #e2e8f0;
            padding: 7px 10px;
            font-size: 10.5px;
            vertical-align: top;
        }
        table.styled-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .badge-green { background-color: #dcfce7; color: #166534; }
        .badge-amber { background-color: #fef3c7; color: #92400e; }
        .badge-blue { background-color: #e0e7ff; color: #3730a3; }

        /* Éléments de timeline / processus */
        .process-row {
            margin-bottom: 10px;
        }
        .process-num {
            display: inline-block;
            background-color: #d97706;
            color: white;
            font-weight: bold;
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 20px;
            border-radius: 50%;
            margin-right: 8px;
            font-size: 10px;
        }

        .clear { clear: both; }
    </style>
</head>
<body>

    <!-- PIED DE PAGE FIXE -->
    <div class="footer">
        <div class="left">Dossier d'Accompagnement BTP • Confidentiel</div>
        <div class="center">Projet Digitalisation Chantiers</div>
        <div class="right">Destinataire : Madame Ghita</div>
        <div class="clear"></div>
    </div>

    <!-- ==================== PAGE 1 : COUVERTURE ==================== -->
    <div class="cover">
        <div class="cover-tag">Offre Stratégique & Cadrage Fonctionnel</div>
        
        <div class="cover-title">
            Digitalisation & Maîtrise des Chantiers <span>BTP Maroc</span>
        </div>
        
        <div class="cover-subtitle">
            Plateforme Intégrée de Gestion des Achats sur Chantier, Circuit de Validation Hiérarchique et Pointage Géolocalisé des Équipes Terrain.
        </div>

        <div class="cover-divider"></div>

        <div class="cover-box">
            <table>
                <tr>
                    <td class="label">Entreprise Cliente :</td>
                    <td class="val">Entreprise Générale de BTP (Chantiers Multi-Villes Maroc)</td>
                </tr>
                <tr>
                    <td class="label">Interlocutrice :</td>
                    <td class="val">Madame Ghita (Direction Générale & Opérationnelle)</td>
                </tr>
                <tr>
                    <td class="label">Périmètre Géographique :</td>
                    <td class="val">Casablanca • Rabat • Tanger • Marrakech & Chantiers Régionaux</td>
                </tr>
                <tr>
                    <td class="label">Type de Projet :</td>
                    <td class="val">Solution Web & Mobile Terrain (PWA) • Hébergement Sécurisé</td>
                </tr>
                <tr>
                    <td class="label">Date d'Émission :</td>
                    <td class="val">{{ now()->format('d F Y') }} • Version 1.0 (Confidentiel)</td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 50px; font-size: 10px; color: #64748b;">
            Document préparé dans le cadre de la réunion de cadrage et de démonstration technique.
        </div>
    </div>

    <div class="page-break"></div>

    <!-- ==================== PAGE 2 : SOMMAIRE & SYNTHÈSE ==================== -->
    <h2 class="section-title">1. Synthèse Exécutive pour Madame Ghita</h2>

    <p style="font-size: 11.5px; line-height: 1.6;">
        Le secteur du BTP au Maroc impose une rigueur d'exécution quotidienne : la dispersion géographique des chantiers (Tanger, Casablanca, Rabat...), la multiplicité des intervenants (chefs de chantier, sous-traitants, journaliers) et l'urgence permanente d'approvisionnement créent des <strong>risques majeurs de fuite de rentabilité</strong>.
    </p>

    <div class="card card-highlight">
        <h3 style="margin-top: 0; color: #0f172a; font-size: 12px;">🎯 Les 3 Piliers de la Solution Développée</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 33%; padding: 6px; vertical-align: top;">
                    <div style="font-weight: bold; color: #d97706; font-size: 11px;">1. Zéro Dépense Fantôme</div>
                    <div style="font-size: 10px; color: #475569; margin-top: 3px;">
                        Toute commande de matériau part obligatoirement d'une Demande d'Achat (DA) validée par le Conducteur et par vous-même (au-delà du seuil fixé).
                    </div>
                </td>
                <td style="width: 33%; padding: 6px; vertical-align: top;">
                    <div style="font-weight: bold; color: #1e3a8a; font-size: 11px;">2. Preuve de Livraison (BL)</div>
                    <div style="font-size: 10px; color: #475569; margin-top: 3px;">
                        À la réception, le chef de chantier prend en photo le Bon de Livraison tamponné. Plus aucune facture ne sera payée sans preuve visuelle.
                    </div>
                </td>
                <td style="width: 33%; padding: 6px; vertical-align: top;">
                    <div style="font-weight: bold; color: #16a34a; font-size: 11px;">3. Pointage Équipe Sécurisé</div>
                    <div style="font-size: 10px; color: #475569; margin-top: 3px;">
                        Saisie en 1 clic pour l'équipe entière avec vérification des coordonnées GPS du chantier. Clôture immédiate des états de paie.
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <h2 class="section-title" style="margin-top: 25px;">2. Diagnostic : Vos Enjeux Métier Actuels</h2>

    <table class="styled-table">
        <thead>
            <tr>
                <th style="width: 25%;">Défi Identifié</th>
                <th style="width: 35%;">Situation Classique BTP (Papier / WhatsApp)</th>
                <th style="width: 40%;">Impact Direct de la Plateforme</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Commandes Urgentes</strong></td>
                <td>Appels téléphoniques informels, messages WhatsApp perdus, contestations de prix avec le fournisseur.</td>
                <td><span class="badge badge-green">Traçabilité 100%</span> : Historique horodaté, référence chantier et montant HT/TTC figé.</td>
            </tr>
            <tr>
                <td><strong>Litiges de Réception</strong></td>
                <td>Bons de livraison papier perdus, matériaux manquants constatés des semaines plus tard au moment de payer.</td>
                <td><span class="badge badge-green">Photo Immédiate</span> : Le BL signé est archivé numériquement dès le déchargement du camion.</td>
            </tr>
            <tr>
                <td><strong>Pointage des Journaliers</strong></td>
                <td>Feuilles de présence papier manuelles, risque d'heures gonflées, consolidation comptable fastidieuse en fin de mois.</td>
                <td><span class="badge badge-green">Pointage 1-Clic</span> : Enregistrement rapide, calcul automatique des coûts journaliers et export Excel instantané.</td>
            </tr>
            <tr>
                <td><strong>Pilotage Multi-Villes</strong></td>
                <td>Difficulté de savoir exactement l'état d'avancement des chantiers distants sans se déplacer sur place.</td>
                <td><span class="badge badge-green">Tableau de Bord</span> : Vision consolidée des effectifs et des dépenses par ville en temps réel.</td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- ==================== PAGE 3 : MODULE ACHATS ==================== -->
    <h2 class="section-title">3. Module Achats & Approvisionnements : Le Circuit Sécurisé</h2>

    <p>
        Le circuit d'achat garantit qu'aucun Dirham ne quitte la trésorerie sans justification préalable, tout en restant ultra-rapide pour ne jamais bloquer le chantier.
    </p>

    <div class="card card-amber">
        <h3 style="margin-top: 0; color: #92400e; font-size: 11.5px;">📋 Les 4 Niveaux de Contrôle Intégrés</h3>
        <div class="process-row">
            <span class="process-num">1</span> <strong>Émission Terrain :</strong> Le chef de chantier saisit les matériaux (sélection directe dans le catalogue des prix négociés ou saisie libre), indique le degré d'urgence (*Normal*, *Urgent*, *Bloquant*) et joint si nécessaire une photo du besoin.
        </div>
        <div class="process-row">
            <span class="process-num">2</span> <strong>Validation Conducteur de Travaux :</strong> Vérification de la conformité technique par rapport à l'étape du chantier et au lot concerné (Gros œuvre, Ferraillage, etc.).
        </div>
        <div class="process-row">
            <span class="process-num">3</span> <strong>Validation Financière Madame Ghita (Direction) :</strong> Règle automatique : si le montant estimé dépasse le seuil défini (ex: <strong>10 000 MAD</strong>), le système exige obligatoirement votre validation personnelle.
        </div>
        <div class="process-row">
            <span class="process-num">4</span> <strong>Émission Bon de Commande Officiel :</strong> Génération automatique du document PDF aux normes marocaines (ICE, IF, RC, TVA 20%, double signature) prêt à envoyer au fournisseur (Lafarge, Cimar, etc.).
        </div>
    </div>

    <h3 class="subsection-title">Spécimen du Bon de Commande Officiel Généré par la Plateforme</h3>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Mention Obligatoire</th>
                <th>Intégration dans le Système</th>
                <th>Bénéfice Comptable & Juridique</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>En-tête de votre Entreprise</strong></td>
                <td>Raison sociale, IF, RC, Patente, ICE et coordonnées bancaires (RIB).</td>
                <td>Crédibilité totale auprès des grands comptes et banques.</td>
            </tr>
            <tr>
                <td><strong>Détail Fournisseur & Chantier</strong></td>
                <td>ICE du fournisseur, nom du chantier de destination et contact chef.</td>
                <td>Livraison à la bonne adresse sans erreur de camion.</td>
            </tr>
            <tr>
                <td><strong>Valorisation Fiscale</strong></td>
                <td>Total HT, Taux TVA normal Maroc (20,00%), Montant TVA, Total TTC.</td>
                <td>Rapprochement comptable sans aucune erreur de calcul.</td>
            </tr>
            <tr>
                <td><strong>Cadre de Double Signature</strong></td>
                <td>Signature Bon pour accord Fournisseur + Visa Direction Travaux.</td>
                <td>Valeur d'engagement contractuel formel.</td>
            </tr>
        </tbody>
    </table>

    <div class="card card-green">
        <strong>Preuve de Réception sur Chantier :</strong> Dès l'arrivée des toupies de béton ou camions d'aciers, le chef de chantier vérifie les quantités et téléverse directement la photo du bon de livraison tamponné. L'historique complet (DA ➔ BC ➔ BL) est consultable en 1 clic par votre service comptabilité.
    </div>

    <div class="page-break"></div>

    <!-- ==================== PAGE 4 : MODULE POINTAGE ==================== -->
    <h2 class="section-title">4. Module Pointage des Équipes & Gestion de la Paie</h2>

    <p>
        Sur un chantier, la gestion des ouvriers (permanents déclarés, sous-traitants, journaliers/tâcherons payés à la semaine ou à la quinzaine) est l'un des postes de dépenses les plus sensibles.
    </p>

    <div class="card card-highlight">
        <h3 style="margin-top: 0; color: #0f172a; font-size: 11.5px;">⚡ L'Innovation "Pointage Rapide d'Équipe" (Conçu pour le smartphone)</h3>
        <p style="margin-bottom: 6px;">
            Les chefs de chantier n'ont ni le temps ni l'envie de passer 45 minutes sur un ordinateur après une journée éprouvante.
        </p>
        <p style="margin-bottom: 6px;">
            <strong>Le fonctionnement en 3 secondes :</strong> Le chef de chantier ouvre l'application sur son téléphone à 17h, clique sur le bouton vert <em>« Pointage Rapide de l'Équipe »</em>. Instantanément, tous les ouvriers assignés au chantier sont cochés comme <strong>Présents (8h)</strong>. Il lui suffit ensuite d'ajuster en 2 clics l'ouvrier absent ou la demi-journée.
        </p>
    </div>

    <h3 class="subsection-title">Référentiel des Corps d'État & Rémunérations BTP</h3>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Corps de Métier</th>
                <th>Type de Contrat</th>
                <th>Suivi dans l'App</th>
                <th>Sécurité Anti-Fraude</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Chefs d'Équipe / Grutiers</strong></td>
                <td>Permanent CNSS</td>
                <td>Heures normales + Heures Sup (HS) de nuit</td>
                <td>Règle anti-doublon (1 seul pointage/jour)</td>
            </tr>
            <tr>
                <td><strong>Maçons / Coffreurs / Ferrailleurs</strong></td>
                <td>Journaliers / Tâcherons</td>
                <td>Taux journalier en MAD (ex: 180 - 200 DH)</td>
                <td>Capture coordonnées GPS chantier</td>
            </tr>
            <tr>
                <td><strong>Électriciens / Plombiers</strong></td>
                <td>Sous-traitants</td>
                <td>Présence par lot de travaux</td>
                <td>Contrôle présence effective sur site</td>
            </tr>
            <tr>
                <td><strong>Manœuvres / Gardiens</strong></td>
                <td>Journaliers</td>
                <td>Taux journalier (ex: 130 - 150 DH)</td>
                <td>Consolidation immédiate pour la paie</td>
            </tr>
        </tbody>
    </table>

    <div class="card card-amber">
        <strong>Validation & Export Paie :</strong>
        <br>À la fin de chaque semaine, le Conducteur de Travaux valide les fiches de pointage d'un clic. Le service comptable extrait directement le fichier Excel récapitulatif avec le total des journées dues, les acomptes et le solde net à payer par ouvrier et par chantier.
    </div>

    <div class="page-break"></div>

    <!-- ==================== PAGE 5 : DÉPLOIEMENT & OFFRE ==================== -->
    <h2 class="section-title">5. Démarche Projet Sans Risque : Le "Chantier Pilote"</h2>

    <p>
        Pour garantir une adoption parfaite par vos équipes sans perturber vos chantiers en cours, nous appliquons une démarche progressive en 4 semaines :
    </p>

    <table class="styled-table">
        <thead>
            <tr>
                <th style="width: 15%;">Période</th>
                <th style="width: 45%;">Actions Réalisées</th>
                <th style="width: 40%;">Livrable Concret</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Semaine 1</strong></td>
                <td>Paramétrage de votre charte graphique (logo, entête), import de votre catalogue matériaux et création des comptes utilisateurs (Mme Ghita, Conducteurs, Chefs).</td>
                <td>Plateforme configurée à l'image exacte de votre société.</td>
            </tr>
            <tr>
                <td><strong>Semaine 2</strong></td>
                <td>Déploiement sur votre hébergement Linux mutualisé et session de formation pratique (30 min) avec 1 ou 2 chefs de chantier test.</td>
                <td>Application accessible sur mobile et desktop.</td>
            </tr>
            <tr>
                <td><strong>Semaine 3</strong></td>
                <td><strong>Phase Pilote sur 1 Chantier</strong> (ex: Tanger ou Casablanca) : Passage réel des demandes d'achat et pointages quotidiens avec assistance directe.</td>
                <td>Premiers bons de commande et fiches de présence réels.</td>
            </tr>
            <tr>
                <td><strong>Semaine 4</strong></td>
                <td>Bilan avec Madame Ghita, ajustements éventuels des seuils et généralisation à l'ensemble de vos chantiers sur toutes les villes.</td>
                <td>Maîtrise complète et autonomie totale de vos équipes.</td>
            </tr>
        </tbody>
    </table>

    <h2 class="section-title" style="margin-top: 25px;">6. Proposition Commerciale & Modalités d'Investissement</h2>

    <table class="styled-table">
        <thead>
            <tr>
                <th style="width: 65%;">Composante de la Prestation</th>
                <th style="width: 35%; text-align: right;">Tarif Forfaitaire (MAD)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Pack Déploiement & Personnalisation Complète :</strong>
                    <br>• Installation et configuration sur votre serveur Linux mutualisé.
                    <br>• Paramétrage des circuits de validation personnalisés et du modèle Bon de Commande PDF.
                    <br>• Configuration des droits d'accès sécurisés (Direction, Conducteurs, Chefs).
                    <br>• Accompagnement et formation pratique sur le Chantier Pilote.
                </td>
                <td style="text-align: right; font-weight: bold; font-size: 13px; color: #d97706;">
                    14 500 MAD HT
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Maintenance Évolutive & Support Sérénité (Optionnel mais recommandé) :</strong>
                    <br>• Sauvegardes hebdomadaires externalisées de la base de données.
                    <br>• Mises à jour de sécurité et monitoring de l'hébergeur.
                    <br>• Assistance téléphonique prioritaire en cas de besoin terrain.
                </td>
                <td style="text-align: right; font-weight: bold; font-size: 11.5px; color: #1e3a8a;">
                    950 MAD / mois
                </td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 40px; padding: 15px; border: 1px solid #cbd5e1; border-radius: 6px; background-color: #f8fafc;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <strong>Pour l'Entreprise Cliente :</strong>
                    <br>Madame Ghita
                    <br><em>« Bon pour accord et lancement du Chantier Pilote »</em>
                    <br><br><br><br>
                    Date & Cachet :
                </td>
                <td style="width: 50%; vertical-align: top; text-align: right;">
                    <strong>Pour le Prestataire :</strong>
                    <br>Consultant & Développeur Solutions BTP
                    <br><em>« Engagement de conformité et livraison »</em>
                    <br><br><br><br>
                    Signature :
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
