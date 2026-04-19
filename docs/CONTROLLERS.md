# Controllers Reference (summary)

## `UserController.php` (src/Controller/UserController.php)

Main responsibilities:

- Handle user login, registration, logout, fetching user data and deleting accounts.
- Simple route dispatch at the end of the file uses `?action=` to trigger operations.

Public methods and usage

- `login()`
  - POST fields: `email`, `password`
  - On success: sets `$_SESSION['user_id']`, `$_SESSION['user_name']`, `$_SESSION['rol']` and redirects to `view/inicio1.php`.

- `register()`
  - POST fields: `nombre`, `email`, `password`, `rol` (optional), `admin_code` (when `rol=admin`), file `foto` (optional for admins).
  - Creates a new user row in `usuarios` and redirects to `inicio1.php` on success.

- `logout()`
  - Clears session and redirects to `inicio1.php`.

- `getUserData($id)`
  - Returns associative array of user record for given id.

- `deleteAccount($id)`
  - Deletes the user row and their profile image (if not `default.png`), then logs out.

Routing

- The bottom of `UserController.php` instantiates the controller and inspects `$_GET['action']`:
  - `?action=logout` → `logout()`
  - `?action=register` → `register()`
  - `?action=deleteAccount` → `deleteAccount()` (requires logged-in user session)
  - Otherwise a POST request invokes `login()`.

Security notes & recommended fixes

- Passwords are stored and compared in plain text. Use `password_hash()` on registration and `password_verify()` on login.
- Login SQL concatenates user input into the query; replace with prepared statements to prevent SQL injection.
- `register()` uses a prepared statement for INSERT, but other queries (SELECT, DELETE) are not prepared — standardize on prepared statements everywhere.
- User-supplied filenames and uploads should be validated more strictly and stored outside the webroot or with randomized filenames.
- Add CSRF tokens to all state-changing forms (register, login, delete account).
- Session handling: consider regenerating session ID on login and setting secure cookie flags (`httponly`, `secure`) in production.

Where to improve code organization

- Move DB connection and credentials to a single `config.php` or environment variables and include from controllers.
- Separate routing from controller class (use a small front controller or simple router file).
