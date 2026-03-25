<?php
session_start();

// 1.5: Evitar acceso si no está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Conectamos a la base de datos para traer los datos más recientes (como la foto)
$conexion = new mysqli("localhost", "root", "", "nightfest_db");
$user_id = $_SESSION['user_id'];
$resultado = $conexion->query("SELECT * FROM usuarios WHERE id = '$user_id'");
$user = $resultado->fetch_assoc();

// Preparar datos para mostrar
$nombre = $user['nombre'];
$email = $user['email'];
$rol = $user['rol'];
$foto = $user['foto_perfil']; // Punto 2.5: Imagen de perfil
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil | NightFest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/STYLE1.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>

<body class="pf-body">

    <header class="pf-header">
        <div class="pf-menu">☰</div>

        <div class="pf-logo">
            <a href="inicio1.php">
                <img src="../assets/img/logoNight.png" class="logo" alt="Logo NightFest">
            </a>
        </div>

        <div class="pf-user"><?php echo htmlspecialchars($rol); ?></div>
    </header>

    <main class="pf-container">

        <h2 class="pf-title">MI PERFIL</h2>

        <div class="pf-card">
            
            <div class="pf-avatar-container">
                <?php if ($rol === 'admin' && $foto !== 'default.png'): ?>
                    <img src="../assets/img/<?php echo $foto; ?>" alt="Foto Perfil" class="pf-avatar-img" style="width:100px; height:100px; border-radius:50%; object-fit:cover;">
                <?php else: ?>
                    <div class="pf-avatar" style="font-size: 50px;">👤</div>
                <?php endif; ?>
            </div>

            <h2><?php echo htmlspecialchars($nombre); ?></h2>
            <p><?php echo htmlspecialchars($email); ?></p>

            <div class="pf-options">
                <?php if ($rol === 'admin'): ?>
                    <button style="background: #d4af37; color: black; font-weight: bold;">PANEL ADMIN</button>
                <?php endif; ?>
                
                <button>Publicaciones</button>
                <button>Favoritos</button>
                <button>Seguridad y privacidad</button>
                
                <button class="logout" onclick="window.location.href='../Controller/logout.php'">Cerrar sesión</button>
            </div>

        </div>

    </main>

    <footer class="pf-footer">
        <div class="pf-links">
            <span>Términos</span>
            <span>Ayuda</span>
            <span>Privacidad</span>
        </div>

        <div class="pf-social">
            <span>🎵</span>
            <span>✖</span>
            <span>📷</span>
            <span>📘</span>
        </div>
    </footer>

</body>
</html>