<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: inicio1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Admin | NightFest</title>
    <link rel="stylesheet" href="../assets/css/STYLE1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="registro-page">
    <div class="registro-container">
        <form action="../Controller/UserController.php?action=register" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="rol" value="admin">

            <h2>Registro Administrador</h2>

            <?php if (isset($_GET['error'])): ?>
                <p class="error-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= htmlspecialchars($_GET['error']) ?>
                </p>
            <?php endif; ?>

            <div class="input-box">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" required>
            </div>

            <div class="input-box">
                <label>Correo Electrónico</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-box">
                <label>Contraseña (mínimo 6 caracteres)</label>
                <input type="password" name="password" required minlength="6">
            </div>

            <div class="input-box">
                <label>Código de Seguridad Admin</label>
                <input type="password" name="admin_code" required placeholder="Código de empresa">
            </div>

            <!-- Req 2.5 — solo admin sube foto -->
            <div class="input-box">
                <label>Foto de Perfil</label>
                <input type="file" name="foto" accept="image/*" required>
            </div>

            <button type="submit" class="btn-submit">Crear Cuenta Admin</button>

            <p style="text-align:center; margin-top:15px;">
                ¿Eres cliente? <a href="registro_estandar.php">Registro Cliente</a>
            </p>
            <p style="text-align:center;">
                ¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a>
            </p>
        </form>
    </div>
</body>
</html>