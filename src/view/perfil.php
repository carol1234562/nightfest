<?php
require_once '../static model/seguridad.php';
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

include_once '../static model/header.php'; 

// 2. MURO DE SEGURIDAD: Si no hay sesión válida, lo expulsamos inmediatamente
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
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

       <?php include '../static model/footer.php'; ?>


</body>
</html>

