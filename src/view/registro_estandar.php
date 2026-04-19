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
    <title>Registro Cliente | NightFest</title>
    <link rel="stylesheet" href="../assets/css/STYLE1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="registro-page">
    <div class="registro-container">
        <form action="../Controller/UserController.php?action=register" method="POST">
            
            <input type="hidden" name="rol" value="estandar">

            <h2>Registro Cliente</h2>

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
                <label>Contraseña</label>
                <input type="password" name="password" required minlength="6">
            </div>

            <button type="submit" class="btn-submit">Crear Cuenta</button>

            <p style="text-align:center; margin-top:15px;">
                ¿Eres administrador? <a href="registro_admin.php">Registro Admin</a>
            </p>
            <p style="text-align:center;">
                ¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a>
            </p>
        </form>
    </div>
</body>
</html>