<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bon de Commande - {{ $bc->numero_bc }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
            margin: 20px;
        }
        .header {
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 2px solid #d97706;
            padding-bottom: 15px;
        }
        .company-info {
            float: left;
            width: 50%;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #b45309;
            text-transform: uppercase;
        }
        .doc-title {
            float: right;
            width: 45%;
            text-align: right;
        }
        .doc-title h1 {
            font-size: 18px;
            margin: 0;
            color: #1f2937;
        }
        .clear {
            clear: both;
        }
        .boxes {
            width: 100%;
            margin-bottom: 20px;
        }
        .box {
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
            padding: 10px;
            border-radius: 4px;
        }
        .box-left {
            float: left;
            width: 48%;
        }
        .box-right {
            float: right;
            width: 48%;
        }
        .box-title {
            font-weight: bold;
            font-size: 11px;
            color: #4b5563;
            text-transform: uppercase;
            border-bottom: 1px solid #d1d5db;
            margin-bottom: 6px;
            padding-bottom: 3px;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        table.items th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        table.items td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            font-size: 11px;
        }
        .totals {
            float: right;
            width: 45%;
            margin-top: 10px;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
        }
        .totals .grand-total {
            background-color: #fef3c7;
            font-weight: bold;
            font-size: 13px;
            color: #92400e;
        }
        .signatures {
            margin-top: 80px;
            width: 100%;
        }
        .sign-box {
            float: left;
            width: 45%;
            border-top: 1px dashed #9ca3af;
            padding-top: 5px;
            text-align: center;
            font-style: italic;
        }
        .sign-box-right {
            float: right;
            width: 45%;
            border-top: 1px dashed #9ca3af;
            padding-top: 5px;
            text-align: center;
            font-style: italic;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="company-info">
            <div class="company-name">ENTREPRISE GÉNÉRALE DE BTP MAROC</div>
            <div>Travaux Publics, Bâtiment & Génie Civil</div>
            <div>Casablanca • Rabat • Tanger • Marrakech</div>
            <div>Tél : +212 5 22 00 00 00 | Email : contact@btpmaroc.ma</div>
            <div>IF : 12345678 • RC : 89765 • ICE : 002134567000099</div>
        </div>
        <div class="doc-title">
            <h1>BON DE COMMANDE</h1>
            <div style="font-size: 13px; font-weight: bold; color: #b45309; margin-top: 4px;">N° {{ $bc->numero_bc }}</div>
            <div style="margin-top: 4px;">Date : {{ \Carbon\Carbon::parse($bc->date_commande)->format('d/m/Y') }}</div>
            <div>Réf Demande : {{ $bc->demandeAchat->numero_da ?? 'N/A' }}</div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="boxes">
        <div class="box box-left">
            <div class="box-title">Fournisseur Attributaire</div>
            <div style="font-size: 13px; font-weight: bold;">{{ $bc->fournisseur->nom }}</div>
            <div>ICE : {{ $bc->fournisseur->ice ?? 'Non renseigné' }}</div>
            <div>Ville : {{ $bc->fournisseur->ville ?? '-' }}</div>
            <div>Adresse : {{ $bc->fournisseur->adresse ?? '-' }}</div>
            <div>Tél : {{ $bc->fournisseur->telephone ?? '-' }}</div>
            <div>Contact : {{ $bc->fournisseur->contact_nom ?? '-' }}</div>
        </div>

        <div class="box box-right">
            <div class="box-title">Lieu de Livraison & Chantier</div>
            <div style="font-size: 13px; font-weight: bold;">{{ $bc->demandeAchat->chantier->nom ?? 'Chantier BTP' }}</div>
            <div>Code Chantier : {{ $bc->demandeAchat->chantier->code ?? '-' }}</div>
            <div>Ville : {{ $bc->demandeAchat->chantier->ville->nom ?? '-' }}</div>
            <div>Adresse : {{ $bc->demandeAchat->chantier->adresse ?? 'Sur le site du chantier' }}</div>
            <div style="margin-top: 4px; font-weight: bold; color: #b45309;">
                Délai impératif : {{ $bc->delai_livraison_prevu ? \Carbon\Carbon::parse($bc->delai_livraison_prevu)->format('d/m/Y') : 'Dès réception' }}
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 50%;">Désignation du Matériau / Prestation</th>
                <th style="width: 10%; text-align: center;">Unité</th>
                <th style="width: 15%; text-align: right;">Quantité</th>
                <th style="width: 20%;">Précisions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bc->demandeAchat->lignesAchat as $index => $ligne)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $ligne->designation }}</strong>
                    @if($ligne->article && $ligne->article->code)
                        <div style="font-size: 9px; color: #6b7280;">Code : {{ $ligne->article->code }}</div>
                    @endif
                </td>
                <td style="text-align: center;">{{ $ligne->unite }}</td>
                <td style="text-align: right; font-weight: bold;">{{ number_format($ligne->quantite_demandee, 2, ',', ' ') }}</td>
                <td style="font-size: 10px; color: #4b5563;">{{ $ligne->remarques ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Aucun article listé</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td><strong>Total Général Hors Taxes (HT) :</strong></td>
                <td style="text-align: right; font-weight: bold;">{{ number_format($bc->montant_total_ht, 2, ',', ' ') }} MAD</td>
            </tr>
            <tr>
                <td>TVA Maroc ({{ number_format($bc->taux_tva, 0) }}%) :</td>
                <td style="text-align: right;">{{ number_format($bc->montant_tva, 2, ',', ' ') }} MAD</td>
            </tr>
            <tr class="grand-total">
                <td><strong>NET À PAYER TOUTES TAXES (TTC) :</strong></td>
                <td style="text-align: right; font-weight: bold;">{{ number_format($bc->montant_total_ttc, 2, ',', ' ') }} MAD</td>
            </tr>
        </table>
        <div style="margin-top: 8px; font-size: 10px; color: #4b5563;">
            Conditions de règlement : <strong>{{ $bc->conditions_paiement ?? 'Selon convention' }}</strong>
        </div>
    </div>
    <div class="clear"></div>

    <div style="margin-top: 25px; padding: 10px; background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 4px; font-size: 10px;">
        <strong>Instructions de livraison importantes :</strong>
        <br>1. La livraison doit impérativement être accompagnée d'un Bon de Livraison (BL) en double exemplaire faisant mention du numéro de bon de commande <strong>{{ $bc->numero_bc }}</strong>.
        <br>2. La décharge doit être contresignée par le Chef de Chantier habilité avec date, nom et tampon du chantier.
    </div>

    <div class="signatures">
        <div class="sign-box">
            Pour le Fournisseur (Bon pour accord & Cachet)
            <br><br><br><br>
        </div>
        <div class="sign-box-right">
            Pour la Direction des Achats & Travaux
            <br><br><br><br>
        </div>
        <div class="clear"></div>
    </div>

    <div class="footer">
        BTP Maroc S.A. au capital de 10.000.000 MAD - Siège social : Casablanca, Maroc - Ce document tient lieu de commande ferme.
    </div>

</body>
</html>
