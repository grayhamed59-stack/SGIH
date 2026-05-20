# SGIH — Système de Gestion Intégré Hospitalier

**SGIH** (*Système de Gestion Intégré Hospitalier*) is a web-based hospital management application built with [Laravel](https://laravel.com). It helps clinics and hospitals in Mali manage patients, appointments, billing, staff roles, and invitations — with a modern French-language interface.

Repository: [github.com/grayhamed59-stack/SGIH](https://github.com/grayhamed59-stack/SGIH/tree/main/SGIH)

---

## Table of contents

- [Features](#features)
- [Tech stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Demo accounts](#demo-accounts)
- [Usage by role](#usage-by-role)
- [Project structure](#project-structure)
- [Useful commands](#useful-commands)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

---

## Features

| Module | Description |
|--------|-------------|
| **Patients** | Create, edit, export, and track patient records |
| **Appointments** | Schedule and cancel appointments with reasons |
| **Doctors** | Doctor profiles and specialties |
| **Payments** | Billing and payment status (comptabilité) |
| **Invitations** | Superadmin generates access codes for new staff |
| **OTP login** | First-time login via one-time code, then password change |
| **Role dashboards** | Tailored views for direction, médecin, comptable, réception |

---

## Tech stack

- **Backend:** PHP 8.3+, Laravel 13
- **Frontend:** Blade, Tailwind CSS, Vite, Alpine.js
- **Auth:** Laravel Breeze (session-based)
- **Database:** MySQL (recommended) or SQLite
- **Testing:** Pest PHP

---

## Requirements

Before you start, install:

| Tool | Version | Check |
|------|---------|-------|
| PHP | 8.3+ | `php -v` |
| Composer | 2.x | `composer -V` |
| Node.js | 18+ LTS | `node -v` |
| MySQL | 8.0+ or MariaDB | running on port 3306 |

Optional: [XAMPP](https://www.apachefriends.org/) / WAMP / phpMyAdmin for local MySQL on Windows.

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/grayhamed59-stack/SGIH.git
cd SGIH/SGIH
```

> The Laravel application lives in the **`SGIH/`** subfolder of the repo root.

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and set your database (MySQL example):

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

Create the database in MySQL:

```sql
CREATE DATABASE sgih CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Migrate and seed demo data

```bash
php artisan migrate --seed
```

This creates tables and four demo staff accounts (see below).

### 5. Build assets and run

**Terminal 1 — Vite (CSS/JS):**

```bash
npm run dev
```

**Terminal 2 — Laravel server:**

```bash
php artisan serve
```

Open **[http://127.0.0.1:8000](http://127.0.0.1:8000)** in your browser.

---

## Demo accounts

After `php artisan migrate --seed`, use these credentials on the login page (`/login`):

| Role | Name | Email | Password |
|------|------|-------|----------|
| **Superadmin** (Direction générale) | Direction Générale | `direction@sgih.com` | `password` |
| **Accountant** (Comptabilité) | Service Comptabilité | `compta@sgih.com` | `password` |
| **Admin / Réception** | Réception Accueil | `reception@sgih.com` | `password` |
| **Doctor** | Dr. Mohamed Diarra | `medecin@sgih.com` | `password` |

> **Security:** These passwords are for **local development only**. Change them before deploying to production.

The seeder also loads sample doctors, patients, appointments, and payments (Mali-themed demo data).

---

## Usage by role

### Superadmin — `direction@sgih.com`

- Dashboard: `/superadmin/dashboard`
- Global overview: patients, doctors, revenue, cancellations
- Manage invitation codes: `/admin/invitations`
- Full access to patient management

### Accountant — `compta@sgih.com`

- Dashboard: `/accountant/dashboard`
- View and mark payments as paid

### Reception — `reception@sgih.com`

- Main dashboard: `/dashboard`
- Patient CRUD: `/patients`
- Export patients: `/patients/export`

### Doctor — `medecin@sgih.com`

- Dashboard: `/doctor/dashboard`
- View appointments linked to patients

### Registering new staff

1. Superadmin creates an invitation code at **Admin → Invitations**.
2. New user registers at `/register` with the code.
3. First login may use **OTP** (`/login/otp`), then set a personal password.

---

## Project structure

```
SGIH/
├── app/
│   ├── Http/Controllers/   # Auth, patients, appointments, roles…
│   ├── Http/Middleware/    # RoleMiddleware, ForcePasswordChange
│   └── Models/             # User, Patient, Doctor, Appointment, Payment…
├── database/
│   ├── migrations/
│   └── seeders/            # DatabaseSeeder.php (demo accounts)
├── resources/views/        # Blade templates (dashboards, auth, patients)
├── routes/
│   ├── web.php             # Main routes + role middleware
│   └── auth.php            # Login, register, OTP, password reset
├── public/                 # Web root (index.php, assets)
├── .env.example
└── README.md               # This file
```

---

## Useful commands

| Command | Purpose |
|---------|---------|
| `php artisan migrate` | Run database migrations |
| `php artisan db:seed` | Load demo users and sample data |
| `php artisan migrate:fresh --seed` | Reset DB and re-seed |
| `php artisan serve` | Start dev server (port 8000) |
| `npm run dev` | Watch and compile frontend assets |
| `npm run build` | Production asset build |
| `php artisan test` | Run Pest tests |

---

## Troubleshooting

### `Invalid default value for 'expires_at'` (MySQL)

If migrations fail on the `invitations` table, ensure you use the latest migration (column type `dateTime` instead of `timestamp`). Then:

```bash
php artisan migrate:fresh --seed
```

### Connection refused (MySQL)

- Start MySQL (XAMPP, `sudo systemctl start mysql`, etc.)
- Verify `DB_*` values in `.env` match your local server

### Login works but wrong dashboard

Each role is redirected automatically after login. Check the `role` column in the `users` table matches: `superadmin`, `accountant`, `doctor`, `admin`, or `receptionist`.

### Assets not loading

Run `npm run dev` or `npm run build` so Vite compiles CSS/JS.

### Seeded users missing

```bash
php artisan db:seed
```

---

## Contributing

1. Create a branch from `main` (avoid pushing directly to `main` if your team uses protected branches).
2. Make your changes in the `SGIH/` app folder.
3. Run tests: `php artisan test`
4. Open a pull request on GitHub.

---

## License

This project is open-source. See the [LICENSE](../LICENSE) file at the repository root.

---

<p align="center">
  <strong>SGIH</strong> — Hospital Management System<br>
  Built with Laravel · Demo context: Bamako, Mali
</p>
