# SGIH — Système de Gestion Intégré Hospitalier

<p align="center">
  Application web de gestion hospitalière · Laravel 13 · Contexte démo : Bamako, Mali
</p>

**SGIH** (*Système de Gestion Intégré Hospitalier*) est une application web permettant aux cliniques et hôpitaux de gérer les **patients**, les **rendez-vous**, la **facturation**, les **rôles du personnel** et les **invitations** d’accès. L’interface est entièrement en français.

**Dépôt GitHub :** [github.com/grayhamed59-stack/SGIH](https://github.com/grayhamed59-stack/SGIH/tree/main/SGIH)

---

## Sommaire

- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Prérequis](#prérequis)
- [Installation rapide](#installation-rapide)
- [Comptes de démonstration](#comptes-de-démonstration)
- [Utilisation par rôle](#utilisation-par-rôle)
- [Export CSV (Excel)](#export-csv-excel)
- [Structure du projet](#structure-du-projet)
- [Commandes utiles](#commandes-utiles)
- [Dépannage](#dépannage)
- [Contribution](#contribution)
- [Licence](#licence)

---

## Fonctionnalités

| Module | Description |
|--------|-------------|
| **Patients** | Création, modification, recherche et archivage des dossiers |
| **Rendez-vous** | Planification et annulation avec motif |
| **Médecins** | Fiches médecins et spécialités |
| **Paiements** | Suivi des factures et statuts (comptabilité) |
| **Invitations** | Codes d’accès générés par la direction pour nouveaux utilisateurs |
| **Connexion OTP** | Première connexion par code à usage unique, puis changement de mot de passe |
| **Tableaux de bord** | Vues dédiées : direction, médecin, comptable, réception |
| **Export CSV** | Export des patients compatible Excel (UTF-8, séparateur `;`) |

---

## Stack technique

| Couche | Technologies |
|--------|----------------|
| **Backend** | PHP 8.3+, Laravel 13 |
| **Frontend** | Blade, Tailwind CSS, Vite, Alpine.js |
| **Authentification** | Laravel Breeze (sessions) |
| **Base de données** | MySQL (recommandé) ou SQLite |
| **Tests** | Pest PHP |

---

## Prérequis

Installez les outils suivants avant de commencer :

| Outil | Version minimale | Vérification |
|-------|------------------|--------------|
| PHP | 8.3+ | `php -v` |
| Composer | 2.x | `composer -V` |
| Node.js | 18 LTS+ | `node -v` |
| MySQL / MariaDB | 8.0+ | port 3306 actif |

**Optionnel (Windows) :** [XAMPP](https://www.apachefriends.org/), WAMP ou phpMyAdmin pour MySQL en local.

---

## Installation rapide

### 1. Cloner le projet

```bash
git clone https://github.com/grayhamed59-stack/SGIH.git
cd SGIH/SGIH
```

> L’application Laravel se trouve dans le sous-dossier **`SGIH/`** à la racine du dépôt.

### 2. Installer les dépendances

```bash
composer install
npm install
```

### 3. Configurer l’environnement

```bash
cp .env.example .env
php artisan key:generate
```

Modifiez le fichier `.env` (exemple MySQL) :

```env
APP_NAME=SGIH
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sgih
DB_USERNAME=root
DB_PASSWORD=
```

Créez la base de données :

```sql
CREATE DATABASE sgih CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Migrer et peupler la base

```bash
php artisan migrate --seed
```

Cette commande crée les tables et **quatre comptes de démonstration** (voir ci-dessous).

### 5. Lancer l’application

**Terminal 1 — assets front-end :**

```bash
npm run dev
```

**Terminal 2 — serveur Laravel :**

```bash
php artisan serve
```

Ouvrez **[http://127.0.0.1:8000](http://127.0.0.1:8000)** dans votre navigateur.

---

## Comptes de démonstration

Après `php artisan migrate --seed`, connectez-vous sur **`/login`** avec :

| Rôle | Nom affiché | E-mail | Mot de passe |
|------|-------------|--------|--------------|
| **Superadmin** (Direction générale) | Direction Générale | `direction@sgih.com` | `password` |
| **Comptable** | Service Comptabilité | `compta@sgih.com` | `password` |
| **Réception** (rôle `admin`) | Réception Accueil | `reception@sgih.com` | `password` |
| **Médecin** | Dr. Mohamed Diarra | `medecin@sgih.com` | `password` |

> **Sécurité :** ces mots de passe sont réservés au **développement local**. Modifiez-les impérativement avant toute mise en production.

Le seeder charge également des **médecins**, **patients**, **rendez-vous** et **paiements** fictifs (données de démo au Mali).

---

## Utilisation par rôle

### Direction générale — `direction@sgih.com`

| Action | URL |
|--------|-----|
| Tableau de bord | `/superadmin/dashboard` |
| Vue d’ensemble (patients, médecins, revenus, annulations) | — |
| Gestion des codes d’invitation | `/admin/invitations` |
| Gestion des patients | `/patients` |

### Comptable — `compta@sgih.com`

| Action | URL |
|--------|-----|
| Tableau de bord | `/accountant/dashboard` |
| Marquer les paiements comme payés | depuis le tableau de bord |

### Réception — `reception@sgih.com`

| Action | URL |
|--------|-----|
| Tableau de bord | `/dashboard` |
| Liste et fiches patients | `/patients` |
| Ajouter un patient | `/patients/create` |
| Exporter en CSV | `/patients/export` |

### Médecin — `medecin@sgih.com`

| Action | URL |
|--------|-----|
| Tableau de bord | `/doctor/dashboard` |
| Consultation des rendez-vous | depuis le tableau de bord |

### Inscrire un nouveau membre du personnel

1. La **direction** crée un code d’invitation dans **Admin → Invitations**.
2. Le nouvel utilisateur s’inscrit sur **`/register`** avec ce code.
3. La **première connexion** peut passer par **`/login/otp`** (code OTP), puis définition d’un mot de passe personnel.

---

## Export CSV (Excel)

Depuis **Gestion des patients** (`/patients`), cliquez sur **Exporter (CSV)** :

- Téléchargement d’un fichier `patients_sgih_AAAA-MM-JJ_HHMMSS.csv`
- Encodage **UTF-8 avec BOM** (accents français corrects dans Excel)
- Séparateur **`;`** (format attendu par Excel en locale française)
- Colonnes : ID, nom, prénom, date de naissance, genre, téléphone, adresse, statut, date d’enregistrement
- Si une recherche est active, l’export ne contient que les patients filtrés

---

## Structure du projet

```
SGIH/
├── app/
│   ├── Http/Controllers/    # Patients, rendez-vous, rôles, auth…
│   ├── Http/Middleware/     # RoleMiddleware, ForcePasswordChange
│   └── Models/              # User, Patient, Doctor, Appointment, Payment…
├── database/
│   ├── migrations/
│   └── seeders/             # DatabaseSeeder.php (comptes démo)
├── resources/views/         # Vues Blade (tableaux de bord, auth, patients)
├── routes/
│   ├── web.php              # Routes principales + middleware rôles
│   └── auth.php             # Connexion, inscription, OTP, mot de passe
├── public/                  # Point d’entrée web
├── .env.example
└── README.md
```

---

## Commandes utiles

| Commande | Description |
|----------|-------------|
| `php artisan migrate` | Exécuter les migrations |
| `php artisan db:seed` | Charger les données de démonstration |
| `php artisan migrate:fresh --seed` | Réinitialiser la base et re-seeder |
| `php artisan serve` | Démarrer le serveur (port 8000) |
| `npm run dev` | Compiler les assets en mode développement |
| `npm run build` | Build de production des assets |
| `php artisan test` | Lancer les tests Pest |

---

## Dépannage

### Erreur `Invalid default value for 'expires_at'` (MySQL)

La migration `invitations` utilise le type `dateTime` pour éviter cette erreur. Réinitialisez si besoin :

```bash
php artisan migrate:fresh --seed
```

### `Connection refused` — MySQL inaccessible

- Démarrez MySQL (`sudo systemctl start mysql`, XAMPP, etc.)
- Vérifiez `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` et `DB_PASSWORD` dans `.env`

### Connexion réussie mais mauvais tableau de bord

Après connexion, la redirection dépend du champ `role` dans la table `users` :  
`superadmin`, `accountant`, `doctor`, `admin` ou `receptionist`.

### Styles ou scripts absents

```bash
npm run dev
# ou en production
npm run build
```

### Comptes de démo introuvables

```bash
php artisan db:seed
```

### L’export CSV ne se télécharge pas

Vérifiez que vous êtes connecté avec un rôle autorisé (réception, direction). Le fichier doit se télécharger automatiquement ; ouvrez-le ensuite dans Excel.

---

## Contribution

1. Créez une branche à partir de `main` (évitez de pousser directement sur `main` si elle est protégée).
2. Travaillez dans le dossier `SGIH/` de l’application.
3. Lancez les tests : `php artisan test`
4. Ouvrez une pull request sur GitHub.

---

## Licence

Projet open source — voir le fichier [LICENSE](../LICENSE) à la racine du dépôt.

---

<p align="center">
  <strong>SGIH</strong> — Système de Gestion Intégré Hospitalier<br>
  Développé avec Laravel
</p>
