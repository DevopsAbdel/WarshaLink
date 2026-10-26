# Guide de Déploiement : Hébergeur Linux Mutualisé (cPanel / OVH / Hostinger / Maroc)

Ce guide détaille pas à pas comment déployer l'application **BTP MAROC** sur n'importe quel hébergement Linux mutualisé avec cPanel ou DirectAdmin.

---

## 1. Principe d'Architecture Sécurisée sur Serveur Mutualisé

Sur un hébergeur mutualisé, **ne placez jamais l'intégralité du projet Laravel dans le dossier `public_html`**, car cela exposerait votre fichier `.env` (mots de passe) et votre code source au public.

La structure recommandée :
```text
/home/votre_identifiant/
│
├── btp_core/                    <-- Dossier privé (invisible depuis internet)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── storage/
│   ├── vendor/
│   ├── .env                     <-- Vos identifiants de production
│   └── artisan
│
└── public_html/                 <-- Dossier public (seul accessible aux navigateurs)
    ├── css/
    ├── js/
    ├── .htaccess
    ├── index.php                <-- Modifié pour pointer vers btp_core
    └── storage/                 <-- Raccourci vers btp_core/storage/app/public
```

---

## 2. Étape par Étape

### Étape 1 : Créer la Base de Données MySQL sur le cPanel
1. Connectez-vous à votre interface **cPanel**.
2. Allez dans **Bases de données MySQL**.
3. Créez une nouvelle base de données (ex: `votrecompte_btp`).
4. Créez un nouvel utilisateur MySQL (ex: `votrecompte_btpuser`) avec un mot de passe robuste.
5. Associez cet utilisateur à la base de données et cochez **TOUS LES PRIVILÈGES**.

### Étape 2 : Préparer et Transférer les Fichiers
1. Depuis votre ordinateur local, compressez le projet en archive ZIP **sauf** les dossiers `node_modules` et `.git`.
2. Via le **Gestionnaire de fichiers cPanel** (File Manager) ou FileZilla FTP :
   - Créez un dossier nommé `btp_core` à la racine de votre compte `/home/votrecompte/`.
   - Extrayez-y le contenu du projet.
   - Déplacez le contenu du dossier `btp_core/public/` dans le dossier public réel `public_html/`.

### Étape 3 : Adapter le fichier `public_html/index.php`
Ouvrez le fichier `public_html/index.php` et modifiez les deux lignes suivantes :

```php
// Remplacer :
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// Par :
require __DIR__.'/../btp_core/vendor/autoload.php';
$app = require_once __DIR__.'/../btp_core/bootstrap/app.php';
```

### Étape 4 : Configurer le fichier `btp_core/.env`
Dans `/home/votrecompte/btp_core/.env`, renseignez les coordonnées de votre base de données :

```env
APP_NAME="BTP MAROC"
APP_ENV=production
APP_KEY=base64:VotreCleGenereeIci
APP_DEBUG=false
APP_URL=https://votredomaine.ma

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=votrecompte_btp
DB_USERNAME=votrecompte_btpuser
DB_PASSWORD=VotreMotDePasseMySQLSecurise
```

### Étape 5 : Exécuter les Migrations et les Données Initiales
- **Option A (Si vous avez accès SSH)** :
  ```bash
  cd /home/votrecompte/btp_core
  php artisan migrate --force
  php artisan db:seed --force
  php artisan storage:link
  ```
- **Option B (Si vous n'avez pas de terminal SSH)** :
  - Depuis votre machine locale, exportez la base de données SQLite ou MySQL via phpMyAdmin.
  - Allez sur le **phpMyAdmin** de votre cPanel et cliquez sur **Importer** pour charger le fichier SQL.

### Étape 6 : Planificateur de Tâches Cron (cPanel)
Pour que les relances d'approbation et l'archivage automatique des pointages fonctionnent, ajoutez une tâche Cron dans cPanel :
- Fréquence : **Chaque minute (`* * * * *`)**
- Commande :
  ```bash
  /usr/local/bin/php /home/votrecompte/btp_core/artisan schedule:run >> /dev/null 2>&1
  ```

---

## 3. Comptes Démo Prêts à l'Emploi

| Rôle | Email | Mot de passe | Périmètre |
| :--- | :--- | :--- | :--- |
| **Direction Générale** | `direction@warshalink.ma` | `password` | National (Toutes les villes & chantiers) |
| **Conducteur Travaux** | `conducteur@warshalink.ma` | `password` | Supervision des 3 chantiers & validation DA/pointages |
| **Chef Chantier Tanger**| `chef.tanger@warshalink.ma` | `password` | Chantier Marina Bay Tanger |
| **Chef Chantier Casa**  | `chef.casa@warshalink.ma` | `password` | Chantier Les Palmiers Casablanca |
| **Responsable Achats**  | `achats@warshalink.ma` | `password` | Négociation fournisseurs & Bons de commande |
| **Responsable RH/Paie** | `rh@warshalink.ma` | `password` | Suivi présences ouvriers & exports salaires |
