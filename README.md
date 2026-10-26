# 🏗️ WarshaLink — Plateforme de Gestion des Chantiers & Achats BTP (Maroc)

<p align="center">
  <strong>La passerelle intelligente entre les chantiers terrain et la direction d'entreprise.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Filament-3.x-F59E0B?style=for-the-badge&logo=livewire&logoColor=white" alt="Filament PHP v3">
  <img src="https://img.shields.io/badge/PHP-8.2%20%7C%208.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Marché-BTP%20Maroc-006233?style=for-the-badge" alt="BTP Maroc">
</p>

---

## 📌 Présentation du Projet

**WarshaLink** est une application web et mobile (PWA) conçue spécifiquement pour répondre aux besoins opérationnels et financiers des entreprises de **Bâtiment et Travaux Publics (BTP)** opérant sur plusieurs villes à travers le Maroc (Casablanca, Rabat, Tanger, Marrakech, etc.).

Elle résout les 3 points de friction majeurs du secteur :
1. **La fuite des dépenses matériaux** : Remplacement des commandes informelles WhatsApp par un workflow de validation hiérarchique strict.
2. **Les litiges de livraison avec les fournisseurs** : Rapprochement automatique Bon de Commande (BC) et photo obligatoire du Bon de Livraison (BL) tamponné.
3. **La gestion de la paie et des présences ouvriers** : Pointage instantané de l'équipe terrain en 1 clic avec contrôle du périmètre GPS du chantier.

---

## 🚀 Fonctionnalités Clés

### 1. 🛒 Module Achats & Approvisionnements
- **Demande d'Achat (DA) Terrain :** Saisie simplifiée sur smartphone par le Chef de Chantier avec niveau d'urgence (*Normal*, *Urgent*, *Bloquant*) et photo du besoin.
- **Circuit de Validation Multi-Niveaux :**
  - Validation technique par le Conducteur de Travaux.
  - Validation financière obligatoire par la **Direction Générale** si le montant dépasse **10 000 MAD**.
- **Émission Bon de Commande Officiel :** Génération automatique de bons de commande PDF au format A4 conformes aux normes fiscales marocaines (TVA 20%, ICE, IF, RC).
- **Réception sur Chantier :** Contrôle de conformité et capture photo du Bon de Livraison (BL) signé.

### 2. 👷 Module Pointage Équipes & RH Terrain
- **Référentiel Métiers :** Chefs d'équipe, Maçons, Ferrailleurs, Coffreurs, Grutiers, Manœuvres...
- **Multi-Statuts :** Permanents CNSS, Journaliers / Tâcherons (payés à la journée), Sous-traitants.
- **⚡ Pointage Rapide en 1 Clic :** Le chef de chantier pointe 20 ouvriers en 3 secondes à 17h.
- **Vérification Géolocalisée :** Contrôle des coordonnées GPS par rapport au rayon autorisé du chantier (anti-fraude).
- **Consolidation Paie :** Validation hebdomadaire par le conducteur et export récapitulatif Excel pour la comptabilité.

### 3. 🏗️ Multi-Villes & Gestion des Chantiers
- Référentiel des villes du Royaume et des chantiers avec budgets alloués et dates d'exécution.
- Cloisonnement des accès (RBAC) : chaque chef de chantier n'accède qu'à son périmètre.

---

## 💻 Stack Technologique

- **Framework Backend :** Laravel 12 (PHP 8.2+)
- **Interface & Dashboard :** Filament PHP v3 (Livewire 3 + Tailwind CSS en mode SPA haute performance)
- **Base de Données :** MySQL / MariaDB / SQLite
- **Moteur d'Édition PDF :** Barryvdh DomPDF
- **Sécurité & Rôles :** Spatie Laravel-Permission
- **Déploiement Cible :** Compatible 100% avec hébergement Linux mutualisé (cPanel, Hostinger, OVH...)

---

## ⚙️ Installation & Démarrage Local

```bash
# 1. Cloner le projet
git clone https://github.com/DevopsAbdel/WarshaLink.git
cd WarshaLink

# 2. Installer les dépendances
composer install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Exécuter les migrations et le jeu d'essai BTP
php artisan migrate --seed

# 5. Lancer le serveur
php artisan serve
```

---

## 🔑 Comptes de Démonstration

| Rôle | Email | Mot de passe |
| :--- | :--- | :--- |
| **Direction Générale** | `direction@warshalink.ma` | `password` |
| **Conducteur de Travaux** | `conducteur@warshalink.ma` | `password` |
| **Chef Chantier Tanger** | `chef.tanger@warshalink.ma` | `password` |
| **Responsable Achats** | `achats@warshalink.ma` | `password` |
| **Responsable RH / Paie** | `rh@warshalink.ma` | `password` |

---

## 📄 Licence & Droits
Propriété exclusive — Développé pour la gestion des chantiers BTP au Maroc.
