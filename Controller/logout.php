<?php
session_start(); // Es vital iniciar la sesión para poder destruirla

// 1. Limpiamos todas las variables de sesión
$_SESSION = array();

// 2. Si se desea destruir la sesión completamente, borramos también la cookie de sesión.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destruimos la sesión
session_destroy();

// 4. Redirigimos al login (Saliendo de Controller y entrando a view)
header("Location: ../view/login.php");
exit();
?>