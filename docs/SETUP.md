# Setup and Installation

Prerequisites

- XAMPP (or equivalent Apache + PHP + MySQL stack)
- PHP 8.x recommended

Steps

1. Copy the project into your webroot, e.g. `C:\xampp\htdocs\project1.dis`.
2. Start Apache and MySQL from the XAMPP control panel.
3. Import the database schema:

   - Using phpMyAdmin: open phpMyAdmin, create database `nightfest`, import `model/db.sql`.
   - Or using CLI:

     mysql -u root -p
     CREATE DATABASE nightfest;
     USE nightfest;
     SOURCE path/to/project1.dis/model/db.sql;

4. Configure database credentials:

   - Currently DB credentials are set in `UserController.php` (constructor). For maintainability, create `src/config.php` with your DB settings and include it in controllers.

5. File uploads and permissions:

   - Ensure `src/assets/img/` is writable by PHP for profile image uploads.

6. Access the app in your browser:

   http://localhost/project1.dis/src/view/inicio1.php

Notes

- If you change DB credentials or DB name, update the code accordingly.
- Use environment variables or a config file for credentials in production.
