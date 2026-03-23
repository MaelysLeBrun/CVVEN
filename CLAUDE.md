# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

CVVEN is a **CodeIgniter 4 hotel reservation system** built with PHP 8.1+. It handles room listings, availability checking, user authentication, and reservation management.

## Development Commands

```bash
# Start development server
php spark serve

# Install dependencies
composer install

# Run tests
composer test
# or
./vendor/bin/phpunit

# Run a single test file
./vendor/bin/phpunit tests/unit/ExampleTest.php
```

The app entry point is `public/index.php`. The web server or `php spark serve` must serve from the `public/` directory.

## Database Setup

No migrations exist — the database must be created manually. The database is named `CVVEN` and connects to MySQL on `127.0.0.1:3306` with user `root` and no password (configured in `app/Config/Database.php`, not `.env`).

### Schema (inferred from models)

| Table | Key columns |
|-------|------------|
| `Utilisateur` | `user_id` (varchar PK), `user_login`, `user_mdp`, `user_nom`, `user_prenom`, `user_mail`, `user_telephone` |
| `Chambre` | `chamb_id` (varchar PK), `chamb_numero`, `chamb_emplacement`, `chamb_remarque`, `type_id` (FK) |
| `Type_Chambre` | `type_id` (PK), `type_libelle`, `type_desc` |
| `Reserve` | `reser_id` (auto-increment PK), `user_id` (FK), `chamb_id` (FK), `reser_dateDebut`, `reser_dateFin` |

## Architecture

### Routing (`app/Config/Routes.php`)

All routes are defined explicitly — no auto-routing. Protected routes (e.g., `chambre/:id`, `mes-reservations`) redirect to login if no session exists. The `Reservation` controller is the newer reservation flow; `Hotel::reserver` is legacy.

### Controllers

- **`Hotel`** — main controller: room listing (`index`), room detail (`detail`), availability (`disponibilite`), legacy reservation (`reserver`), user reservation list (`mesReservations`), cancellation (`annuler`)
- **`LoginController`** — registration, login, logout; auto-generates `user_id` in `USR001` format and `user_login` as `firstname[0] + lastname + counter`
- **`Reservation`** — newer reservation flow for authenticated users; includes an AJAX endpoint `checkDisponibilite` that returns JSON

### Models

- **`ChambreModel`** — queries rooms and availability; key method `getChambresDisponiblesParType($typeId, $dateDebut, $dateFin)` uses date-overlap logic
- **`ReserveModel`** — creates/cancels reservations; `isChambreDisponible` checks for date overlaps; `annulerReservation` enforces ownership and prevents cancellation after start date
- **`UserModel`** — maps to `Utilisateur`; `user_id` is a string (not auto-increment), manually generated

### Session

Session variables used throughout: `user_id`, `user_login`, `isLoggedIn`. File-based session driver (default CI4).

### Frontend

Views use **Alpine.js** for interactivity. CSS is separated into `public/assets/css/`. Views are in `app/Views/hotel/` (main pages), `app/Views/auth/` (login/register), and `app/Views/Pages/` (reservation form).

## Conventions

- Table names are French (`Chambre`, `Utilisateur`, `Reserve`, `Type_Chambre`)
- Primary keys use French prefixes: `chamb_id`, `user_id`, `reser_id`, `type_id`
- String PKs (e.g., `user_id`) are manually generated, not auto-increment
- The `Hotel` controller handles both room browsing and the legacy reservation flow; prefer `Reservation` controller for new reservation logic
