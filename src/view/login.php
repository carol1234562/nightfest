<?php
session_start();
if (isset($_SESSION['user_name'])) {
    header("Location: inicio1.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NightFest</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="STYLE1.CSS">
    <link rel="stylesheet" href="STYLE_LOGIN.CSS">
</head>

<body class="login-page">

    <div class="login-screen">
        <div class="return-container" onclick="window.location.href='inicio1.php'">
            <i class="fas fa-angle-left"></i>
            <span>Volver</span>
        </div>

        <form action="../Controller/procesar_login.php" method="POST" class="login-form-container">
            <img src="logoNight.png" class="logo-login" alt="Logo NightFest">

            <?php if (isset($_GET['error'])): ?>
                <p class="error-msg" style="color: #ff4d4d; text-align: center; margin-bottom: 10px;">
                    Correo o contraseña incorrectos.
                </p>
            <?php endif; ?>

            <div class="input-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
            </div>

            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
                <a href="recuperar.php" class="forgot-link">¿Olvidaste tu contraseña?</a>
            </div>

            <p class="texto-cuenta">
                ¿No tienes cuenta? <a href="registro.html" class="link-registro">Regístrate</a>
            </p>

            <input type="submit" value="Iniciar sesión" class="btn-login-submit">
        </form>
    </div>
</body>

</html>