<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WarshaLink — Kit de Lancement Marque</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            background: #f8fafc;
            color: #1e293b;
            font-size: 13px;
            line-height: 1.6;
        }

        /* ─── COVER PAGE ─── */
        .cover {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f4c81 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 60px 40px;
            position: relative;
            page-break-after: always;
        }

        .cover::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .cover-logo {
            font-size: 52px;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: -2px;
            margin-bottom: 8px;
            position: relative;
        }

        .cover-logo span {
            color: #f59e0b;
        }

        .cover-tagline {
            font-size: 16px;
            color: #94a3b8;
            margin-bottom: 50px;
            letter-spacing: 2px;
            text-transform: uppercase;
            position: relative;
        }

        .cover-divider {
            width: 80px;
            height: 4px;
            background: #f59e0b;
            margin: 0 auto 50px;
            border-radius: 2px;
            position: relative;
        }

        .cover-title {
            font-size: 36px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 16px;
            position: relative;
        }

        .cover-subtitle {
            font-size: 16px;
            color: #cbd5e1;
            margin-bottom: 60px;
            max-width: 500px;
            position: relative;
        }

        .cover-badge {
            display: inline-block;
            background: rgba(245, 158, 11, 0.2);
            border: 1px solid #f59e0b;
            color: #fbbf24;
            padding: 8px 24px;
            border-radius: 50px;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 20px;
            position: relative;
        }

        .cover-date {
            position: absolute;
            bottom: 40px;
            right: 40px;
            color: #64748b;
            font-size: 11px;
        }

        .cover-domain {
            position: absolute;
            bottom: 40px;
            left: 40px;
            color: #64748b;
            font-size: 11px;
        }

        /* ─── PAGE LAYOUT ─── */
        .page {
            padding: 50px 50px;
            background: #ffffff;
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        /* ─── SECTION HEADER ─── */
        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 16px;
            border-bottom: 2px solid #e2e8f0;
        }

        .section-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-right: 16px;
            flex-shrink: 0;
        }

        .section-icon.instagram { background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
        .section-icon.facebook  { background: #1877f2; }
        .section-icon.youtube   { background: #ff0000; }
        .section-icon.tiktok    { background: #010101; }
        .section-icon.linkedin  { background: #0077b5; }
        .section-icon.brand     { background: linear-gradient(135deg, #0f4c81, #f59e0b); }
        .section-icon.strategy  { background: linear-gradient(135deg, #059669, #10b981); }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
        }

        .section-subtitle {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }

        /* ─── CARDS ─── */
        .card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .card-accent {
            border-left: 4px solid #f59e0b;
        }

        .card-blue {
            border-left: 4px solid #3b82f6;
            background: #eff6ff;
        }

        .card-green {
            border-left: 4px solid #10b981;
            background: #ecfdf5;
        }

        .card-red {
            border-left: 4px solid #ef4444;
            background: #fef2f2;
        }

        .card-purple {
            border-left: 4px solid #8b5cf6;
            background: #f5f3ff;
        }

        .card-dark {
            background: #0f172a;
            border: none;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .card-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .card-label.light { color: #94a3b8; }

        .card-text {
            font-size: 13px;
            color: #374151;
            line-height: 1.8;
        }

        .card-text.light { color: #e2e8f0; }

        .bio-text {
            font-size: 15px;
            color: #1e293b;
            line-height: 1.9;
            font-style: italic;
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 12px;
            border: 1px solid #e2e8f0;
        }

        .bio-text.dark-bio {
            background: #1e293b;
            color: #e2e8f0;
            border: 1px solid #334155;
        }

        /* ─── CHAR COUNT ─── */
        .char-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            margin-left: 8px;
            vertical-align: middle;
        }

        .char-ok  { background: #d1fae5; color: #065f46; }
        .char-warn { background: #fef3c7; color: #92400e; }

        /* ─── HASHTAGS ─── */
        .hashtag-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .hashtag {
            background: #e0f2fe;
            color: #0369a1;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .hashtag.yellow { background: #fef3c7; color: #92400e; }
        .hashtag.green  { background: #d1fae5; color: #065f46; }
        .hashtag.red    { background: #fee2e2; color: #991b1b; }
        .hashtag.purple { background: #ede9fe; color: #5b21b6; }

        /* ─── GRID ─── */
        .grid-2 { display: table; width: 100%; border-spacing: 16px; }
        .grid-2 .col { display: table-cell; width: 50%; vertical-align: top; }

        /* ─── INFO BLOCKS ─── */
        .info-row {
            display: flex;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child { border-bottom: none; }

        .info-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 140px;
            flex-shrink: 0;
            padding-top: 2px;
        }

        .info-value {
            font-size: 13px;
            color: #1e293b;
            flex: 1;
        }

        /* ─── PLATFORM BANNER ─── */
        .platform-banner {
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }

        .platform-banner .icon { font-size: 28px; margin-right: 16px; }
        .platform-banner .info {}
        .platform-banner .name { font-size: 16px; font-weight: 700; }
        .platform-banner .handle { font-size: 12px; opacity: 0.8; margin-top: 2px; }

        .banner-insta { background: linear-gradient(90deg, #f09433, #dc2743, #bc1888); color: white; }
        .banner-fb    { background: #1877f2; color: white; }
        .banner-yt    { background: #ff0000; color: white; }
        .banner-tt    { background: #010101; color: white; }
        .banner-li    { background: #0077b5; color: white; }

        /* ─── CHECKLIST ─── */
        .checklist { list-style: none; }
        .checklist li {
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            color: #374151;
            padding-left: 24px;
            position: relative;
        }
        .checklist li::before {
            content: '☐';
            position: absolute;
            left: 0;
            color: #94a3b8;
        }
        .checklist li:last-child { border-bottom: none; }

        .checklist li strong { color: #0f172a; }

        /* ─── TIMELINE ─── */
        .timeline-item {
            display: flex;
            margin-bottom: 20px;
        }
        .timeline-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f59e0b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            color: white;
            flex-shrink: 0;
            margin-right: 16px;
            margin-top: 4px;
        }
        .timeline-content {}
        .timeline-title { font-weight: 700; color: #0f172a; font-size: 14px; }
        .timeline-desc { color: #64748b; font-size: 12px; margin-top: 4px; }

        /* ─── TIP BOX ─── */
        .tip {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 14px 18px;
            margin-top: 16px;
        }
        .tip-title { font-weight: 700; color: #92400e; font-size: 12px; margin-bottom: 4px; }
        .tip-text  { color: #78350f; font-size: 12px; line-height: 1.6; }

        /* ─── FOOTER ─── */
        .page-footer {
            position: fixed;
            bottom: 20px;
            left: 50px;
            right: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            font-size: 10px;
            color: #94a3b8;
        }

        .footer-brand { font-weight: 700; color: #f59e0b; }

        /* ─── HIGHLIGHT BOX ─── */
        .highlight {
            background: linear-gradient(135deg, #0f172a, #1e3a5f);
            border-radius: 16px;
            padding: 30px;
            color: white;
            text-align: center;
            margin: 20px 0;
        }
        .highlight h3 { font-size: 20px; color: #fbbf24; margin-bottom: 10px; }
        .highlight p  { color: #cbd5e1; font-size: 13px; }

        /* ─── TABLE ─── */
        table { width: 100%; border-collapse: collapse; }
        thead { background: #0f172a; color: white; }
        thead th { padding: 12px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 11px 16px; font-size: 12px; border-bottom: 1px solid #e2e8f0; color: #374151; }
        tbody td strong { color: #0f172a; }

        /* ─── PAGE BREAK ─── */
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

<!-- ═══════════════════════════════════════════════════════ -->
<!-- COVER PAGE -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="cover">
    <div class="cover-badge">Kit de Lancement Officiel</div>
    <div class="cover-logo">Warsha<span>Link</span></div>
    <div class="cover-tagline">Connecter vos chantiers · Simplifier votre gestion</div>
    <div class="cover-divider"></div>
    <div class="cover-title">📱 Brand Launch Kit</div>
    <div class="cover-subtitle">
        Textes officiels, bios réseaux sociaux, stratégie de contenu<br>
        et guide de lancement pour la marque WarshaLink
    </div>

    <table style="border-collapse:collapse; margin-top:20px; position:relative;">
        <tr>
            <td style="padding:10px 20px; background:rgba(255,255,255,0.08); border-radius:8px; text-align:center; color:#e2e8f0; font-size:13px; border:1px solid rgba(255,255,255,0.1);">
                🌐 warshalink.ma
            </td>
            <td style="width:16px;"></td>
            <td style="padding:10px 20px; background:rgba(255,255,255,0.08); border-radius:8px; text-align:center; color:#e2e8f0; font-size:13px; border:1px solid rgba(255,255,255,0.1);">
                📸 @warshalink
            </td>
            <td style="width:16px;"></td>
            <td style="padding:10px 20px; background:rgba(255,255,255,0.08); border-radius:8px; text-align:center; color:#e2e8f0; font-size:13px; border:1px solid rgba(255,255,255,0.1);">
                📘 /warshalink
            </td>
        </tr>
    </table>

    <div class="cover-date">Octobre 2026 · Confidentiel</div>
    <div class="cover-domain">Préparé par WarshaLink Dev Team</div>
</div>


<!-- ═══════════════════════════════════════════════════════ -->
<!-- PAGE 1 — IDENTITÉ DE MARQUE -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="page">
    <div class="section-header">
        <div class="section-icon brand">🏷️</div>
        <div>
            <div class="section-title">Identité de Marque WarshaLink</div>
            <div class="section-subtitle">Charte de communication · Éléments fondateurs</div>
        </div>
    </div>

    <!-- Infos clés -->
    <div class="card card-accent">
        <div class="card-label">Fiche Identité</div>
        <div class="info-row">
            <div class="info-label">Nom de marque</div>
            <div class="info-value"><strong>WarshaLink</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Prononciation</div>
            <div class="info-value">War-sha-Link (وَرشة لينك)</div>
        </div>
        <div class="info-row">
            <div class="info-label">Secteur</div>
            <div class="info-value">BTP · Bâtiment & Travaux Publics · Maroc</div>
        </div>
        <div class="info-row">
            <div class="info-label">Site web</div>
            <div class="info-value">warshalink.ma</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email contact</div>
            <div class="info-value">contact@warshalink.ma</div>
        </div>
        <div class="info-row">
            <div class="info-label">Cible principale</div>
            <div class="info-value">Conducteurs de travaux, Directeurs BTP, PME construction</div>
        </div>
        <div class="info-row">
            <div class="info-label">Marché</div>
            <div class="info-value">Maroc (lancement) · MENA (expansion)</div>
        </div>
        <div class="info-row">
            <div class="info-label">Couleurs principales</div>
            <div class="info-value">Bleu nuit #0f172a · Ambre/Or #f59e0b · Blanc #ffffff</div>
        </div>
    </div>

    <!-- Taglines -->
    <div style="margin-top: 24px;">
        <div class="card-label" style="margin-bottom:12px;">✨ TAGLINES OFFICIELLES (choisir selon contexte)</div>

        <div class="card card-blue">
            <div class="card-label">Tagline principale — Français</div>
            <div class="bio-text" style="font-size:17px; font-style:normal; font-weight:700; text-align:center; color:#1e3a8a;">
                "Connecter vos chantiers, simplifier votre gestion."
            </div>
        </div>

        <div class="card" style="border-left:4px solid #f59e0b;">
            <div class="card-label">Tagline courte — Réseaux sociaux</div>
            <div class="bio-text" style="font-size:16px; font-style:normal; font-weight:600; text-align:center;">
                "La warsha, connectée."
            </div>
        </div>

        <div class="card card-purple">
            <div class="card-label">Tagline — Anglais (international)</div>
            <div class="bio-text" style="font-size:15px; font-style:normal; font-weight:600; text-align:center; color:#4c1d95;">
                "Where construction connects."
            </div>
        </div>
    </div>

    <div class="tip">
        <div class="tip-title">💡 Conseil Pro — Cohérence de marque</div>
        <div class="tip-text">Utilisez <strong>toujours le même logo, la même photo de profil et le même bio de base</strong> sur tous les réseaux. 
        La cohérence visuelle multiplie par 3 la mémorisation de votre marque. 
        Commencez par Instagram et Facebook, puis YouTube dans un second temps.</div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════ -->
<!-- PAGE 2 — INSTAGRAM -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="page">
    <div class="platform-banner banner-insta">
        <div class="icon">📸</div>
        <div class="info">
            <div class="name">Instagram</div>
            <div class="handle">@warshalink · instagram.com/warshalink</div>
        </div>
    </div>

    <!-- Bio principale -->
    <div class="card card-accent">
        <div class="card-label">
            BIO PRINCIPALE (150 caractères max)
            <span class="char-badge char-ok">✓ 148 car.</span>
        </div>
        <div class="bio-text dark-bio" style="font-family: monospace; font-size: 14px;">
🏗️ WarshaLink — La plateforme BTP du Maroc<br>
📊 Gestion chantiers · Achats · Pointage RH<br>
🔗 Demandez votre démo gratuite 👇<br>
🌐 warshalink.ma
        </div>
    </div>

    <!-- Bio version 2 -->
    <div class="card" style="border-left:4px solid #dc2743;">
        <div class="card-label">
            BIO VERSION 2 — Orientée bénéfices
            <span class="char-badge char-ok">✓ 145 car.</span>
        </div>
        <div class="bio-text dark-bio" style="font-family: monospace; font-size: 14px;">
✅ Fini les tableaux Excel chaotiques !<br>
🏗️ Gérez vos chantiers en 1 clic<br>
📍 Pointage GPS · Commandes · Approbations<br>
👇 Essai gratuit → warshalink.ma
        </div>
    </div>

    <!-- Hashtags -->
    <div class="card card-green">
        <div class="card-label">☑️ HASHTAGS — Kit complet à copier</div>

        <div style="margin-top:8px; margin-bottom:12px;">
            <div style="font-size:11px; font-weight:700; color:#065f46; margin-bottom:6px;">HASHTAGS MAROC (priorité)</div>
            <div class="hashtag-cloud">
                <span class="hashtag green">#MarocBTP</span>
                <span class="hashtag green">#ChantierMaroc</span>
                <span class="hashtag green">#BTPMaroc</span>
                <span class="hashtag green">#ConstructionMaroc</span>
                <span class="hashtag green">#EntrepriseBTP</span>
                <span class="hashtag green">#GestionChantier</span>
                <span class="hashtag green">#MaisonMaroc</span>
                <span class="hashtag green">#ImmobilierMaroc</span>
            </div>
        </div>

        <div style="margin-top:8px; margin-bottom:12px;">
            <div style="font-size:11px; font-weight:700; color:#1e3a8a; margin-bottom:6px;">HASHTAGS TECH & SECTEUR</div>
            <div class="hashtag-cloud">
                <span class="hashtag">#GestionProjet</span>
                <span class="hashtag">#ERPConstruction</span>
                <span class="hashtag">#SaaS</span>
                <span class="hashtag">#TransformationDigitale</span>
                <span class="hashtag">#StartupMaroc</span>
                <span class="hashtag">#TechMaroc</span>
                <span class="hashtag">#DigitalBTP</span>
            </div>
        </div>

        <div style="margin-top:8px;">
            <div style="font-size:11px; font-weight:700; color:#92400e; margin-bottom:6px;">HASHTAG MARQUE (à toujours inclure)</div>
            <div class="hashtag-cloud">
                <span class="hashtag yellow">#WarshaLink</span>
                <span class="hashtag yellow">#LaWarshaCOnnectée</span>
                <span class="hashtag yellow">#WarshaLinkBTP</span>
            </div>
        </div>
    </div>

    <!-- Légende photo de profil -->
    <div class="card" style="border-left:4px solid #bc1888;">
        <div class="card-label">📷 PROFIL RECOMMANDÉ</div>
        <table style="border-collapse:collapse; margin-top:8px;">
            <tr>
                <td style="padding:6px 0; font-size:12px; color:#374151; width:140px; font-weight:700; color:#64748b; font-size:11px; text-transform:uppercase;">Photo de profil</td>
                <td style="padding:6px 0; font-size:12px; color:#374151;">Logo WarshaLink sur fond bleu nuit (#0f172a) — format carré 1:1</td>
            </tr>
            <tr>
                <td style="padding:6px 0; font-size:12px; color:#374151; font-weight:700; color:#64748b; font-size:11px; text-transform:uppercase;">Nom affiché</td>
                <td style="padding:6px 0; font-size:12px; color:#374151;">WarshaLink BTP</td>
            </tr>
            <tr>
                <td style="padding:6px 0; font-size:12px; color:#374151; font-weight:700; color:#64748b; font-size:11px; text-transform:uppercase;">Nom d'utilisateur</td>
                <td style="padding:6px 0; font-size:12px; color:#374151;">@warshalink</td>
            </tr>
            <tr>
                <td style="padding:6px 0; font-size:12px; color:#374151; font-weight:700; color:#64748b; font-size:11px; text-transform:uppercase;">Catégorie</td>
                <td style="padding:6px 0; font-size:12px; color:#374151;">Logiciels (Software)</td>
            </tr>
            <tr>
                <td style="padding:6px 0; font-size:12px; color:#374151; font-weight:700; color:#64748b; font-size:11px; text-transform:uppercase;">Lien en bio</td>
                <td style="padding:6px 0; font-size:12px; color:#374151;">https://warshalink.ma</td>
            </tr>
        </table>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════ -->
<!-- PAGE 3 — FACEBOOK -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="page">
    <div class="platform-banner banner-fb">
        <div class="icon">📘</div>
        <div class="info">
            <div class="name">Facebook Page</div>
            <div class="handle">facebook.com/warshalink</div>
        </div>
    </div>

    <!-- Nom + catégorie -->
    <div class="card card-blue">
        <div class="card-label">⚙️ CONFIGURATION DE LA PAGE</div>
        <div class="info-row">
            <div class="info-label">Nom de la page</div>
            <div class="info-value"><strong>WarshaLink — Gestion BTP Maroc</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Catégorie principale</div>
            <div class="info-value">Entreprise de logiciels</div>
        </div>
        <div class="info-row">
            <div class="info-label">Catégorie secondaire</div>
            <div class="info-value">Services aux entreprises</div>
        </div>
        <div class="info-row">
            <div class="info-label">Nom d'utilisateur</div>
            <div class="info-value">@warshalink</div>
        </div>
        <div class="info-row">
            <div class="info-label">Site web</div>
            <div class="info-value">https://warshalink.ma</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email</div>
            <div class="info-value">contact@warshalink.ma</div>
        </div>
        <div class="info-row">
            <div class="info-label">Pays</div>
            <div class="info-value">Maroc 🇲🇦</div>
        </div>
    </div>

    <!-- Description courte -->
    <div class="card card-accent">
        <div class="card-label">
            DESCRIPTION COURTE — (255 caractères)
            <span class="char-badge char-ok">✓ 210 car.</span>
        </div>
        <div class="bio-text">
            WarshaLink est la plateforme digitale dédiée aux entreprises BTP au Maroc. 
            Gérez vos chantiers, vos achats et votre équipe depuis un seul tableau de bord. 
            Demandez votre démonstration gratuite sur warshalink.ma
        </div>
    </div>

    <!-- À propos long -->
    <div class="card card-accent" style="border-left:4px solid #1877f2; background:#eff6ff;">
        <div class="card-label">📄 TEXTE "À PROPOS" COMPLET — Section About Facebook</div>
        <div class="bio-text" style="font-size:13px; line-height:2; font-style:normal;">
<strong>🏗️ WarshaLink — La plateforme de gestion BTP pensée pour le Maroc</strong><br><br>

Nous sommes une équipe de passionnés du digital et du secteur BTP qui ont créé WarshaLink pour résoudre un problème concret : 
la gestion des chantiers au Maroc est encore trop souvent faite à la main, sur papier ou avec des tableaux Excel désorganisés.<br><br>

<strong>Ce que WarshaLink vous permet de faire :</strong><br>
✅ Gérer tous vos chantiers depuis un seul tableau de bord<br>
✅ Suivre les demandes d'achat avec un circuit d'approbation clair<br>
✅ Émettre des bons de commande professionnels en 1 clic<br>
✅ Valider les réceptions de marchandises (BL) avec photos<br>
✅ Pointer votre équipe avec géolocalisation GPS<br>
✅ Exporter vos données pour la paie et la comptabilité<br><br>

<strong>Pour qui ?</strong><br>
🔶 Conducteurs de travaux et chefs de chantier<br>
🔶 Directeurs techniques et directeurs généraux BTP<br>
🔶 PME et ETI du secteur construction au Maroc<br><br>

<strong>Contactez-nous pour une démonstration gratuite :</strong><br>
📧 contact@warshalink.ma<br>
🌐 warshalink.ma<br>
📍 Maroc 🇲🇦
        </div>
    </div>

    <div class="tip">
        <div class="tip-title">💡 Astuce Facebook — Bouton d'appel à l'action</div>
        <div class="tip-text">Dans la configuration de votre Page Facebook, activez le bouton CTA : 
        choisissez <strong>"Envoyer un message"</strong> ou <strong>"En savoir plus"</strong> (pointant vers warshalink.ma). 
        Ce bouton apparaît directement sur votre page et augmente les conversions de 30%.</div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════ -->
<!-- PAGE 4 — YOUTUBE -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="page">
    <div class="platform-banner banner-yt">
        <div class="icon">🎥</div>
        <div class="info">
            <div class="name">YouTube Channel</div>
            <div class="handle">youtube.com/@warshalink</div>
        </div>
    </div>

    <!-- Config chaîne -->
    <div class="card card-red">
        <div class="card-label">⚙️ CONFIGURATION DE LA CHAÎNE</div>
        <div class="info-row">
            <div class="info-label">Nom de la chaîne</div>
            <div class="info-value"><strong>WarshaLink BTP</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Handle</div>
            <div class="info-value">@warshalink</div>
        </div>
        <div class="info-row">
            <div class="info-label">Catégorie</div>
            <div class="info-value">Science et technologie</div>
        </div>
        <div class="info-row">
            <div class="info-label">Pays</div>
            <div class="info-value">Maroc</div>
        </div>
        <div class="info-row">
            <div class="info-label">Email contact</div>
            <div class="info-value">contact@warshalink.ma</div>
        </div>
        <div class="info-row">
            <div class="info-label">Site web</div>
            <div class="info-value">https://warshalink.ma</div>
        </div>
    </div>

    <!-- Description chaîne -->
    <div class="card" style="border-left:4px solid #ff0000; background:#fff5f5;">
        <div class="card-label">📝 DESCRIPTION OFFICIELLE DE LA CHAÎNE YouTube</div>
        <div class="bio-text" style="font-style:normal; font-size:13px; line-height:2;">
<strong>Bienvenue sur la chaîne officielle de WarshaLink 🏗️</strong><br><br>

WarshaLink est la plateforme digitale de gestion BTP conçue spécialement pour les entreprises marocaines du secteur construction et bâtiment.<br><br>

<strong>Sur cette chaîne, vous trouverez :</strong><br>
🎬 Démos complètes de la plateforme WarshaLink<br>
📚 Tutoriels pas à pas (gestion des achats, pointage équipe, chantiers)<br>
💡 Conseils de gestion BTP pour les conducteurs de travaux<br>
📊 Cas d'usage réels d'entreprises marocaines<br>
🔴 Lives : Q&amp;A, nouvelles fonctionnalités, webinaires<br><br>

<strong>WarshaLink vous permet de :</strong><br>
✅ Centraliser la gestion de tous vos chantiers<br>
✅ Automatiser le circuit d'approbation des achats<br>
✅ Pointer votre équipe avec GPS en temps réel<br>
✅ Générer vos bons de commande et rapports PDF<br><br>

👉 Demandez votre démo gratuite : <strong>warshalink.ma</strong><br>
📧 Contact : contact@warshalink.ma<br><br>

<strong>#WarshaLink #BTPMaroc #GestionChantier #ConstructionMaroc</strong>
        </div>
    </div>

    <!-- Playlist suggérées -->
    <div class="card card-green">
        <div class="card-label">🎬 PLAYLISTS RECOMMANDÉES — À créer dès le lancement</div>
        <table style="margin-top:8px;">
            <thead>
                <tr>
                    <th>Nom de la Playlist</th>
                    <th>Contenu</th>
                    <th>Priorité</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>🚀 Démarrer avec WarshaLink</strong></td>
                    <td>Vidéos d'onboarding, première connexion</td>
                    <td>⭐⭐⭐</td>
                </tr>
                <tr>
                    <td><strong>🛒 Gestion des Achats</strong></td>
                    <td>DA, BC, réceptions, approbations</td>
                    <td>⭐⭐⭐</td>
                </tr>
                <tr>
                    <td><strong>👷 Pointage & RH</strong></td>
                    <td>Pointage GPS, export paie</td>
                    <td>⭐⭐</td>
                </tr>
                <tr>
                    <td><strong>💡 Conseils BTP Maroc</strong></td>
                    <td>Contenus éducatifs secteur</td>
                    <td>⭐⭐</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════ -->
<!-- PAGE 5 — TIKTOK + LINKEDIN -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="page">

    <!-- TikTok -->
    <div class="platform-banner banner-tt">
        <div class="icon">🎵</div>
        <div class="info">
            <div class="name">TikTok</div>
            <div class="handle">@warshalink · tiktok.com/@warshalink</div>
        </div>
    </div>

    <div class="card card-dark">
        <div class="card-label light">BIO TIKTOK (80 caractères max) <span class="char-badge char-ok" style="background:rgba(255,255,255,0.1); color:#86efac;">✓ 75 car.</span></div>
        <div class="bio-text dark-bio" style="font-family: monospace; font-size:16px; text-align:center; margin-top:12px;">
🏗️ WarshaLink — Gestion BTP Maroc<br>
Chantiers · Achats · Pointage GPS<br>
👇 warshalink.ma
        </div>
    </div>

    <div class="card" style="border-left:4px solid #010101;">
        <div class="card-label">💡 IDÉES DE CONTENUS TIKTOK (format court 30-60 sec)</div>
        <ul class="checklist">
            <li><strong>"Avant/Après" :</strong> Gestion papier vs WarshaLink (transformation digitale)</li>
            <li><strong>Day in the life :</strong> Conducteur de travaux qui utilise WarshaLink</li>
            <li><strong>Démo rapide :</strong> "Créer un bon de commande en 30 secondes"</li>
            <li><strong>Pain point :</strong> "Tu cherches encore tes tableaux Excel ? 😅"</li>
            <li><strong>Behind the scenes :</strong> Comment on a construit WarshaLink</li>
        </ul>
    </div>

    <div style="height:24px;"></div>

    <!-- LinkedIn -->
    <div class="platform-banner banner-li">
        <div class="icon">💼</div>
        <div class="info">
            <div class="name">LinkedIn Company Page</div>
            <div class="handle">linkedin.com/company/warshalink</div>
        </div>
    </div>

    <div class="card card-blue">
        <div class="card-label">⚙️ CONFIGURATION LINKEDIN</div>
        <div class="info-row">
            <div class="info-label">Nom entreprise</div>
            <div class="info-value"><strong>WarshaLink</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Secteur</div>
            <div class="info-value">Logiciels informatiques</div>
        </div>
        <div class="info-row">
            <div class="info-label">Taille</div>
            <div class="info-value">Auto-entrepreneur / 1-10 employés</div>
        </div>
        <div class="info-row">
            <div class="info-label">Siège</div>
            <div class="info-value">Maroc</div>
        </div>
    </div>

    <div class="card" style="border-left:4px solid #0077b5; background:#eff6ff;">
        <div class="card-label">📝 DESCRIPTION LINKEDIN (2000 car. max)</div>
        <div class="bio-text" style="font-style:normal; font-size:13px; line-height:1.9;">
WarshaLink est une solution SaaS marocaine dédiée à la digitalisation des entreprises du secteur BTP.<br><br>

Notre plateforme offre une suite complète d'outils de gestion : suivi des chantiers multi-sites, circuit d'approbation des achats, gestion des bons de commande et réceptions, pointage RH avec géolocalisation GPS, et reporting avancé — le tout accessible depuis n'importe quel appareil.<br><br>

Conçu par des développeurs marocains pour le marché local, WarshaLink comprend les réalités du terrain BTP au Maroc : multi-villes, multi-chantiers, validation hiérarchique et conformité aux pratiques comptables locales.<br><br>

📧 contact@warshalink.ma · 🌐 warshalink.ma
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════ -->
<!-- PAGE 6 — STRATÉGIE DE LANCEMENT -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="page">
    <div class="section-header">
        <div class="section-icon strategy">🚀</div>
        <div>
            <div class="section-title">Plan de Lancement — 30 Premiers Jours</div>
            <div class="section-subtitle">Stratégie Social Media · Actions prioritaires</div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="timeline-item">
        <div class="timeline-dot">1</div>
        <div class="timeline-content">
            <div class="timeline-title">Semaine 1 — Création des comptes (URGENT)</div>
            <div class="timeline-desc">
                Créer tous les comptes avec le même logo, bio et lien warshalink.ma.<br>
                Priorité : <strong>Instagram → Facebook → YouTube → LinkedIn → TikTok</strong>
            </div>
        </div>
    </div>

    <div class="timeline-item">
        <div class="timeline-dot">2</div>
        <div class="timeline-content">
            <div class="timeline-title">Semaine 2 — Premier contenu (3-5 posts)</div>
            <div class="timeline-desc">
                Post d'annonce "WarshaLink est arrivé 🔥", présentation de l'équipe, 
                première démo vidéo du dashboard, témoignage du 1er client bêta.
            </div>
        </div>
    </div>

    <div class="timeline-item">
        <div class="timeline-dot">3</div>
        <div class="timeline-content">
            <div class="timeline-title">Semaine 3 — Routine de contenu</div>
            <div class="timeline-desc">
                3 posts/semaine minimum. Mix : tutoriels (40%) · témoignages (30%) · coulisses (20%) · promotions (10%).
                Utiliser les hashtags de ce kit pour chaque post.
            </div>
        </div>
    </div>

    <div class="timeline-item">
        <div class="timeline-dot">4</div>
        <div class="timeline-content">
            <div class="timeline-title">Semaine 4 — Campagne de lancement officiel</div>
            <div class="timeline-desc">
                Offre de lancement "50% pendant 3 mois pour les 10 premiers clients". 
                Booster le meilleur post Facebook (budget: 100-200 MAD/jour pendant 7 jours).
            </div>
        </div>
    </div>

    <!-- Tableau des KPIs -->
    <div style="margin-top:24px; margin-bottom:16px;">
        <div class="card-label" style="margin-bottom:12px;">📊 OBJECTIFS MOIS 1 — KPIs à suivre</div>
        <table>
            <thead>
                <tr>
                    <th>Plateforme</th>
                    <th>Objectif Abonnés</th>
                    <th>Posts/Semaine</th>
                    <th>Priorité</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>📸 Instagram</td>
                    <td><strong>200 followers</strong></td>
                    <td>4-5 posts</td>
                    <td>🔴 Haute</td>
                </tr>
                <tr>
                    <td>📘 Facebook</td>
                    <td><strong>150 likes</strong></td>
                    <td>3-4 posts</td>
                    <td>🔴 Haute</td>
                </tr>
                <tr>
                    <td>💼 LinkedIn</td>
                    <td><strong>100 followers</strong></td>
                    <td>2-3 posts</td>
                    <td>🟡 Moyenne</td>
                </tr>
                <tr>
                    <td>🎥 YouTube</td>
                    <td><strong>50 abonnés</strong></td>
                    <td>1-2 vidéos</td>
                    <td>🟡 Moyenne</td>
                </tr>
                <tr>
                    <td>🎵 TikTok</td>
                    <td><strong>100 followers</strong></td>
                    <td>3-4 vidéos</td>
                    <td>🟢 Optionnel</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tip">
        <div class="tip-title">🏆 La règle d'or du contenu BTP au Maroc</div>
        <div class="tip-text">
            Le contenu qui performe le mieux sur les réseaux pour le BTP marocain : 
            <strong>les vidéos courtes de démonstration</strong> (30-60 sec) montrant un problème réel suivi de la solution avec WarshaLink. 
            Filmez simplement avec votre téléphone — l'authenticité prime sur la perfection technique. 
            Ajoutez toujours des sous-titres en <strong>Darija + Français</strong> pour toucher plus de monde.
        </div>
    </div>

    <!-- Last highlight -->
    <div class="highlight">
        <h3>🎯 Message clé à retenir</h3>
        <p>
            WarshaLink n'est pas juste un logiciel — c'est le partenaire digital<br>
            des entreprises BTP marocaines qui veulent passer à la vitesse supérieure.<br><br>
            <strong style="color:#fbbf24;">Chaque post, chaque story, chaque vidéo doit transmettre ce message.</strong>
        </p>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════ -->
<!-- PAGE 7 — CHECKLIST DE LANCEMENT -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="page" style="page-break-after: avoid;">
    <div class="section-header">
        <div class="section-icon strategy" style="background: linear-gradient(135deg, #7c3aed, #4f46e5);">☑️</div>
        <div>
            <div class="section-title">Checklist Complète de Lancement</div>
            <div class="section-subtitle">À compléter avant le lancement officiel de WarshaLink</div>
        </div>
    </div>

    <div style="display:table; width:100%; border-spacing:20px;">
        <div style="display:table-row;">
            <div style="display:table-cell; width:50%; vertical-align:top;">

                <div class="card card-blue" style="margin-bottom:16px;">
                    <div class="card-label">🌐 DOMAINE & HÉBERGEMENT</div>
                    <ul class="checklist">
                        <li>Enregistrer <strong>warshalink.ma</strong> sur nic.ma</li>
                        <li>Configurer les DNS vers l'hébergement cPanel</li>
                        <li>Activer le certificat SSL gratuit (Let's Encrypt)</li>
                        <li>Mettre en ligne la landing page de présentation</li>
                        <li>Configurer <strong>contact@warshalink.ma</strong></li>
                    </ul>
                </div>

                <div class="card card-green">
                    <div class="card-label">📱 RÉSEAUX SOCIAUX</div>
                    <ul class="checklist">
                        <li>Créer compte Instagram <strong>@warshalink</strong></li>
                        <li>Créer page Facebook <strong>/warshalink</strong></li>
                        <li>Créer chaîne YouTube <strong>@warshalink</strong></li>
                        <li>Créer page LinkedIn <strong>/company/warshalink</strong></li>
                        <li>Créer compte TikTok <strong>@warshalink</strong></li>
                        <li>Uploader logo sur tous les profils</li>
                        <li>Copier les bios de ce document</li>
                        <li>Ajouter le lien warshalink.ma partout</li>
                    </ul>
                </div>

            </div>
            <div style="display:table-cell; width:50%; vertical-align:top;">

                <div class="card" style="border-left:4px solid #f59e0b; margin-bottom:16px;">
                    <div class="card-label">🏗️ APPLICATION WARSHALINK</div>
                    <ul class="checklist">
                        <li>Déployer l'app sur warshalink.ma</li>
                        <li>Configurer la base de données MySQL prod</li>
                        <li>Tester toutes les fonctionnalités en prod</li>
                        <li>Créer le compte demo client (demo@warshalink.ma)</li>
                        <li>Préparer la vidéo démo de 3 minutes</li>
                    </ul>
                </div>

                <div class="card card-purple">
                    <div class="card-label">📧 COMMUNICATION</div>
                    <ul class="checklist">
                        <li>Configurer email contact@warshalink.ma</li>
                        <li>Préparer email de bienvenue clients</li>
                        <li>Créer plaquette commerciale PDF (✅ fait)</li>
                        <li>Préparer offre de lancement spéciale</li>
                        <li>Contacter 10 premières entreprises BTP</li>
                    </ul>
                </div>

                <div class="card card-red">
                    <div class="card-label">📊 ANALYTICS & SUIVI</div>
                    <ul class="checklist">
                        <li>Configurer Google Analytics sur warshalink.ma</li>
                        <li>Activer Facebook Pixel sur le site</li>
                        <li>Créer tableau de bord de suivi des leads</li>
                        <li>Définir les KPIs mensuels</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Final message -->
    <div style="background: linear-gradient(90deg, #0f172a, #1e3a5f); border-radius:12px; padding:24px; text-align:center; margin-top:10px;">
        <div style="font-size:24px; margin-bottom:10px;">🚀</div>
        <div style="font-size:18px; font-weight:700; color:#fbbf24; margin-bottom:8px;">Prêt pour le lancement de WarshaLink !</div>
        <div style="font-size:13px; color:#cbd5e1; line-height:1.8;">
            Ce kit de lancement est votre feuille de route complète.<br>
            Commencez par enregistrer <strong style="color:#f59e0b;">warshalink.ma</strong> et créer vos comptes sociaux aujourd'hui.
        </div>
        <div style="margin-top:16px; font-size:12px; color:#64748b;">
            📧 contact@warshalink.ma · 🌐 warshalink.ma · 📸 @warshalink
        </div>
    </div>
</div>

</body>
</html>
