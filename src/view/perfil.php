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
    <link rel="stylesheet" href="../assets/css/perfil.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="pf-body">

    <header class="main-header">
    <div class="header-left">
        <a href="inicio1.php">
            <img src="../assets/img/logo.png" class="logo-medium" alt="NightFest Logo">
        </a>
        
        <nav class="nav-menu">
            <a href="inicio1.php" class="active">HOME</a>
            <a href="destacados_page.php">DESTACADOS</a>
            <a href="<?php echo $is_logged ? 'discotecas.php' : 'login.php'; ?>">DISCOTECAS</a>
            <a href="<?php echo $is_logged ? 'bares.php' : 'login.php'; ?>">BARES</a>
            <a href="<?php echo $is_logged ? 'festivales.php' : 'login.php'; ?>">FESTIVALES</a>
            <a href="<?php echo $is_logged ? 'restaurantes.php' : 'login.php'; ?>">RESTAURANTES</a>
            <?php if ($es_admin): ?>
                <a href="mis_eventos.php" class="admin-link">MIS EVENTOS</a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="auth-buttons">
        <?php if ($is_logged): ?>
            <div class="user-panel">
                <a href="perfil.php" class="user-avatar-link">
                    <div class="user-avatar"><?php echo $inicial; ?></div>
                </a>
                <div class="user-actions">
                    <?php if ($es_admin): ?>
                        <a href="crear_evento.php" class="icon-plus" title="Crear Evento"><i class="fas fa-plus"></i></a>
                    <?php endif; ?>
                    <a href="../Controller/UserController.php?action=logout" class="btn-logout-icon" title="Cerrar Sesión"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        <?php else: ?>
            <a href="login.php" class="btn-login">Iniciar Sesión</a>
            <a href="registro_estandar.php" class="btn-register">Registrarse</a>
        <?php endif; ?>
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

    <footer class="main-footer">
    <div class="footer-content">
        <div class="footer-socials">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-tiktok"></i></a>
        </div>

        <div class="footer-legal">
            <a href="#">Términos y Condiciones</a>
            <span class="divider">|</span>
            <a href="#">Política de Privacidad</a>
            <span class="divider">|</span>
            <a href="#">Ayuda</a>
        </div>

        <p class="copyright">© 2026 NightFest. Johan & Carolina.</p>
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