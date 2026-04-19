# Project Documentation

Short overview

- Project: NightFest (simple PHP MVC user management + views)
- Location: application code under `src/`, DB schema in `model/db.sql`

Quick links

- Setup instructions: `docs/SETUP.md`
- Controller reference & security notes: `docs/CONTROLLERS.md`

How to run (local)

1. Start XAMPP (Apache + MySQL).
2. Import `model/db.sql` into MySQL (database name: `nightfest`).
3. Ensure the project folder is inside your webroot (e.g. `C:\xampp\htdocs\project1.dis`).
4. Open `http://localhost/project1.dis/src/view/inicio1.php` in your browser.

Where to look in the repo

- Views: `src/view/`
- Controllers: `src/Controller/` (e.g. `UserController.php`)
- Public assets: `src/assets/` (images, css)
- Database: `model/db.sql`

Recommended next steps

- Move DB credentials into a single config file (`src/config.php`).
- Replace plain-text password handling with `password_hash()` / `password_verify()`.
- Use prepared statements for all SQL queries.
- Add CSRF protection on forms and validate/sanitize inputs.
