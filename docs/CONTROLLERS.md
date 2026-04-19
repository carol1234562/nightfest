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

## Diccionario de Datos

Tabla: `usuarios`

- `id` : INT, PK, AUTO_INCREMENT — Identificador único del usuario.
- `nombre` : VARCHAR(100) NOT NULL — Nombre completo o nombre mostrado del usuario.
- `email` : VARCHAR(150) NOT NULL UNIQUE — Correo electrónico (uso para login y contacto).
- `password` : VARCHAR(255) NOT NULL — Contraseña del usuario (actualmente en texto plano; ver recomendaciones).
- `rol` : ENUM('estandar','admin') DEFAULT 'estandar' — Rol del usuario que condiciona permisos y vistas.
- `foto_perfil` : VARCHAR(255) DEFAULT 'default.png' — Nombre de archivo de la imagen de perfil almacenada en `src/assets/img/`.
- `fecha_registro` : TIMESTAMP DEFAULT CURRENT_TIMESTAMP — Marca temporal de creación del registro.

Índices relevantes

- Índice en `email` para búsquedas y validación de unicidad.

Notas

- Longitud de `password` preparada para almacenar hashes (`password_hash()`), por lo que `VARCHAR(255)` es adecuado.
- `foto_perfil` contiene sólo el nombre de archivo; la ruta física efectiva usada por la aplicación es `src/assets/img/<foto_perfil>`.

## Flujo de Trabajo: registro y guardado de imagen

1. El usuario completa el formulario de registro en la vista (por ejemplo `view/registro_admin.php` o `view/registro_estandar.php`) con campos `nombre`, `email`, `password`, `rol` y, opcionalmente para administradores, un archivo `foto`.
2. El formulario envía una petición POST a `src/Controller/UserController.php` (ruta controlada por `?action=register` o por la acción del formulario).
3. En `register()` se realizan validaciones iniciales:
  - Validación del formato de `email` con `filter_var()`.
  - Validación de longitud mínima de `password`.
  - Para `rol=admin`, comprobación del `admin_code`.
4. Si se ha subido una imagen y el rol es `admin`, se valida la extensión contra una lista permitida (`jpg`, `jpeg`, `png`, `gif`, `webp`).
5. Se genera un nombre de archivo seguro/randomizado: `perfil_<timestamp>.<ext>` y se mueve el archivo temporal a la carpeta de activos:

  move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/" . $nombre_foto);

  - Nota: la ruta usada por el controller asume que `UserController.php` está en `src/Controller/` y que la carpeta de destino es `src/assets/img/` (la ruta relativa en el código es `../assets/img/`).
6. Se inserta el registro en la tabla `usuarios` — actualmente mediante una sentencia preparada para el INSERT — con el campo `foto_perfil` apuntando al nombre de archivo guardado (o `default.png` si no se subió imagen).
7. Tras la inserción exitosa, el usuario es redirigido a la página principal (`view/inicio1.php`). En caso de error se redirige a la página de registro con un parámetro `error`.
