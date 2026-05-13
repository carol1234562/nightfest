<?php
require_once '../Controller/UserController.php';
if (session_status() === PHP_SESSION_NONE) session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache"); 
header("Expires: 0");

// 1. Verificar si está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$uc = new UserController();
$user = $uc->getUserData($_SESSION['user_id']);

if (!$user) {
    header("Location: ../Controller/UserController.php?action=logout");
    exit();
}

$nombre = $user['nombre'];
$email = $user['email'];
$rol = $user['rol'];
$foto = $user['foto_perfil'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil | NightFest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/PROJECT1.DIS/src/assets/css/perfil.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="pf-body">

    <header class="main-header">
        
        <nav class="nav-menu">
            <a href="inicio1.php">HOME</a>
            <a href="#">DESTACADOS</a>
            <a href="#">DISCOTECAS</a>
            <a href="#">BARES</a>
            <a href="#">FESTIVALES</a>
            <a href="#">RESTAURANTES</a>
            <a href="#" class="btn-mis-eventos">MIS EVENTOS</a>
        </nav>
        <div class="user-panel">
            <div class="user-avatar"><?php echo strtoupper(substr($rol, 0, 1)); ?></div>
            <div class="user-actions">
                <a href="#" class="icon-plus">+</a>
                <a href="../Controller/UserController.php?action=logout" class="btn-logout-icon" title="Cerrar Sesión">➜</a>
            </div>
        </div>
    </header>

    <main class="container pf-main-content">
    <h2 class="section-title">MI PERFIL</h2>

    <div class="pf-profile-card">
        <div class="pf-card-header">
            <div class="pf-avatar-wrapper">
<img src="../assets/img/<?php echo $foto; ?>" alt="Foto Perfil" class="pf-avatar-img">            </div>
            <div class="pf-user-info">
                <h2><?php echo htmlspecialchars($nombre); ?></h2>
                <p class="pf-email"><?php echo htmlspecialchars($email); ?></p>
                <span class="pf-role-badge"><?php echo htmlspecialchars($rol); ?></span>
            </div>
        </div>

        <div class="pf-card-options">
            <h4 class="pf-options-title">Opciones de Cuenta</h4>
            <div class="pf-options-grid">
                <?php if ($rol === 'admin'): ?>
                    <button class="pf-btn pf-btn-admin">PANEL ADMIN</button>
                <?php endif; ?>
                <button class="pf-btn">Publicaciones</button>
                <button class="pf-btn">Favoritos</button>
                <button class="pf-btn">Seguridad</button>
<button class="pf-btn pf-btn-logout" 
        onclick="window.location.href='../Controller/UserController.php?action=logout'">
    Cerrar sesión
</button>
            </div>
        </div>
    </div>
</main>

    <footer class="simple-footer">
        <div class="footer-legal">
            <a href="#">Términos</a> <span class="divider">|</span>
            <a href="#">Ayuda</a> <span class="divider">|</span>
            <a href="#">Privacidad</a>
        </div>
        <div class="copyright">
            NightFest © 2023 - Todos los derechos reservados
        </div>
    </footer>

    <script>
    function confirmarBorrado() {
        if (confirm("¿Estás COMPLETAMENTE SEGURO? Esta acción no se puede deshacer y perderás todos tus datos.")) {
            alert("Acción de borrado simulada. Aquí redirigirías al controlador.");
        }
    }
    </script>

</body>
</html>