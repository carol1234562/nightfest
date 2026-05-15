<?php
require_once '../Controller/UserController.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Seguridad: Evitar caché y verificar sesión
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache"); 
header("Expires: 0");

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
$foto_usuario = $user['foto_profile'] ?? $user['foto_perfil']; 
$carpeta_img = '../assets/img/';

// Variables de usuario
$nombre   = $user['nombre'];
$email    = $user['email'];
$rol      = $user['rol'];
$es_admin = ($rol === 'admin');

// Inicial para el avatar circular
$inicial  = strtoupper(substr(trim($nombre), 0, 1));

// CORRECCIÓN: Validar si existe el archivo físico en la carpeta
if (!empty($foto_usuario) && file_exists($carpeta_img . $foto_usuario)) {
    $foto_url = $carpeta_img . $foto_usuario;
} else {
    // Si en la BD dice 'default.png' pero tu archivo físico es 'default.jpg' (o viceversa)
    // Nos aseguramos de apuntar al archivo real que tienes en tu carpeta de assets
    $foto_url = $carpeta_img . 'default.jpg'; 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil | NightFest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/perfil.css">
</head>

<body class="pf-body">

    <header class="nf-header-main">
        <div class="nf-logo-side">
            <a href="inicio1.php">
                <img src="../assets/img/logo.png" alt="NightFest Logo">
            </a>
        </div>

        <nav class="nf-nav">
            <ul>
                <li><a href="inicio1.php">HOME</a></li>
                <li><a href="destacados_page.php">DESTACADOS</a></li>
                <li><a href="discotecas.php">DISCOTECAS</a></li>
                <li><a href="bares.php">BARES</a></li>
                <li><a href="festivales.php">FESTIVALES</a></li>
                <li><a href="restaurantes.php">RESTAURANTES</a></li>
                <?php if ($es_admin): ?>
                    <li><a href="mis_eventos.php" class="btn-mis-eventos">MIS EVENTOS</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="nf-user-controls">
            <a href="perfil.php" style="text-decoration: none;">
                <div class="user-circle"><?php echo $inicial; ?></div>
            </a>
            
            <?php if ($es_admin): ?>
                <a href="registro_admin.php" class="icon-add" title="Agregar Evento">
                    <i class="fas fa-plus-circle"></i>
                </a>
            <?php endif; ?>
            
            <a href="../Controller/UserController.php?action=logout" class="icon-logout" title="Cerrar Sesión">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </header>

    <main class="container pf-main-content">
        <h2 class="section-title">MI PERFIL</h2>

        <div class="pf-profile-card">
            <div class="pf-card-header">
                <div class="pf-avatar-container">
            <img src="<?php echo $foto_url; ?>" alt="Foto Perfil" class="pf-avatar-img">
                </div>
                <div class="pf-user-info">
                    <h2><?php echo htmlspecialchars($nombre); ?></h2>
                    <p class="pf-email"><?php echo htmlspecialchars($email); ?></p>
                    <span class="pf-role-badge" data-role="<?php echo $rol; ?>">
                        <?php echo strtoupper($rol); ?>
                    </span>
                </div>
            </div>

            <div class="pf-card-options">
                <h4 class="pf-options-title">Opciones de Cuenta</h4>
                <div class="pf-options-grid">
                    <?php if ($es_admin): ?>
                        <button class="pf-btn pf-btn-admin" onclick="window.location.href='admin_panel.php'">PANEL ADMIN</button>
                        <button class="pf-btn" onclick="window.location.href='mis_publicaciones.php'">PUBLICACIONES</button>
                    <?php else: ?>
                        <button class="pf-btn" onclick="window.location.href='favoritos.php'">FAVORITOS</button>
                        <button class="pf-btn" onclick="window.location.href='reservas.php'">RESERVAS</button>
                    <?php endif; ?>
                    
                    <button class="pf-btn">SEGURIDAD</button>
                    <button class="pf-btn pf-btn-logout" onclick="window.location.href='../Controller/UserController.php?action=logout'">
                        CERRAR SESIÓN
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

</body>
</html>