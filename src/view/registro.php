<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro | NightFest</title>
    <link rel="stylesheet" href="../assets/css/STYLE1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="registro-page">
    <div class="registro-container">
        <form action="../Controller/UserController.php?action=register" method="POST" enctype="multipart/form-data">
            <h2>Crear Cuenta</h2>

            <?php if (isset($_GET['error'])): ?>
                <p class="error-alert"><?php echo htmlspecialchars($_GET['error']); ?></p>
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
                <input type="password" name="password" required>
            </div>

            <div class="input-box">
                <label>Tipo de Usuario</label>
                <select name="rol" id="rolSelect" onchange="checkAdmin()">
                    <option value="estandar">Cliente Estándar</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>

            <div id="adminFields" style="display: none; border-left: 3px solid #d4af37; padding-left: 15px; margin-top: 10px;">
                <div class="input-box">
                    <label>Código de Seguridad Admin</label>
                    <input type="password" name="admin_code" placeholder="Código de empresa">
                </div>
                <div class="input-box">
                    <label>Foto de Perfil (Requerido para Admin)</label>
                    <input type="file" name="foto" accept="image/*">
                </div>
            </div>

            <button type="submit" class="btn-submit">Finalizar Registro</button>
        </form>
    </div>

    <script>
        function checkAdmin() {
            const rol = document.getElementById('rolSelect').value;
            document.getElementById('adminFields').style.display = (rol === 'admin') ? 'block' : 'none';
        }
    </script>
</body>

</html>