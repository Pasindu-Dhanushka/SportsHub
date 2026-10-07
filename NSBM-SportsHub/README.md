# NSBM SportsHub

A polished PHP + MySQL **Sports Club Management System** built for the Web and Mobile Application Development final project (Topic 3).

## What is included

- Separate **Admin** and **Student** experiences
- Secure register/login/logout with `password_hash()` / `password_verify()`
- Session-based role authorization and CSRF protection
- PDO prepared statements
- Responsive professional UI with dark/light theme and animations
- Sports club CRUD and membership approval workflow
- Training session CRUD
- Match / fixture CRUD
- Tournament CRUD and student registration
- Match result / score CRUD
- Facility and equipment booking CRUD + approval workflow
- Student participation history CRUD
- Admin reports / analytics
- Search and status filtering
- Realistic seed data for demonstrations

## Requirements

- PHP 8.1+
- MySQL 8+ / MariaDB compatible setup
- Apache (XAMPP/WAMP/MAMP) **or** PHP's built-in development server

No Composer or Node.js installation is required.

## Quick setup with XAMPP

1. Copy the folder to `C:/xampp/htdocs/NSBM-SportsHub`.
2. Start **Apache** and **MySQL** from XAMPP.
3. Open phpMyAdmin.
4. Import `database/schema.sql`.
5. Import `database/seed.sql`.
6. Open `config/database.php` and confirm the local credentials. XAMPP defaults normally work as-is (`root` with blank password).
7. Visit:
   - `http://localhost/NSBM-SportsHub/`

If the app is inside a subfolder and generated links do not match your setup, set `APP_URL`, or change the `base_url` value in `config/config.php` to `/NSBM-SportsHub`.

## Alternative: PHP built-in server

From the project folder:

```bash
php -S localhost:8000
```

Then open `http://localhost:8000`.

## Demo accounts

### Admin
- Email: `admin@sportshub.lk`
- Password: `Admin@123`

### Student
- Email: `student@sportshub.lk`
- Password: `Student@123`

> Change demo passwords before deploying publicly.

## Main project structure

```text
NSBM-SportsHub/
├── app/
│   ├── Controllers/
│   ├── Core/
│   ├── Models/
│   └── Services/
├── assets/
│   ├── css/app.css
│   └── js/app.js
├── config/
│   ├── config.php
│   ├── database.php
│   └── modules.php
├── database/
│   ├── schema.sql
│   └── seed.sql
├── views/
│   ├── auth/
│   ├── dashboard/
│   ├── modules/
│   ├── pages/
│   └── partials/
└── index.php
```

## Architecture

The application uses a lightweight MVC/layered structure:

- **Views**: UI pages and reusable partials
- **Controllers**: request handling and application flow
- **Models**: user/club data access
- **Services**: sports-specific business actions
- **Core**: database, authentication, CSRF and view infrastructure
- **Configuration-driven CRUD**: keeps repetitive CRUD modules consistent without mixing SQL into the UI

## Security notes

- Passwords are stored using PHP password hashing.
- SQL operations use PDO prepared statements.
- POST mutations include CSRF tokens.
- Admin/student authorization is enforced server-side.
- Student-owned booking, membership and registration records are scoped to the current account.
- Output is escaped with `htmlspecialchars()` through the `e()` helper.

## UI / UX

The interface was designed as a modern athletics dashboard rather than a default Bootstrap admin template. It includes:

- Animated landing hero and fixture card
- Glass / layered surfaces
- Responsive dashboard/sidebar
- Micro-interactions, count-up stats and reveal animations
- Light/dark theme persistence
- Responsive data tables and forms
- Status chips and actionable empty states
- Print-friendly reports

## Deployment

Any PHP/MySQL-compatible host can be used. Before production deployment:

1. Create a production database and import the SQL files.
2. Update database credentials using environment variables or `config/database.php`.
3. Set `APP_DEBUG=false`.
4. Set the correct `APP_URL` when hosted in a subdirectory.
5. Replace demo credentials.

## Suggested demonstration flow

1. Public landing page and responsive UI
2. Student registration / login
3. Browse sports clubs and send a join request
4. Submit an equipment/facility booking
5. Register for a tournament
6. Admin login
7. Approve membership and booking requests
8. Create/edit a fixture or training session
9. Record a match result
10. Show participation history and admin reports

---

Built for the **NSBM SportsHub – Sports Club Management System** project.
