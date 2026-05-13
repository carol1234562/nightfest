<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "NightFest");

if ($conexion->connect_error) {
    die("Error de conexión");
}

// Lógica de usuario logueado
$is_logged = isset($_SESSION['user_id']);
$es_admin = ($is_logged && $_SESSION['rol'] === 'admin');
$inicial = ($is_logged && isset($_SESSION['user_name'])) ? strtoupper(substr($_SESSION['user_name'], 0, 1)) : "";

// Obtener ID del evento
$id_evento = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Consulta de datos del evento
$sql = "SELECT * FROM eventos WHERE id = $id_evento";
$resultado = $conexion->query($sql);
$evento = $resultado->fetch_assoc();

if (!$evento) {
    die("Evento no encontrado");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NightFest - <?php echo htmlspecialchars($evento['artista']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/infoevento.css">
</head>
<body id="infoevento-page">

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
                <li><a href="#">BARES</a></li>
                <li><a href="#">FESTIVALES</a></li>
                <li><a href="#">RESTAURANTES</a></li>
                <?php if ($es_admin): ?>
                    <li><a href="mis_eventos.php" class="btn-mis-eventos">MIS EVENTOS</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="nf-user-controls">
            <?php if ($is_logged): ?>
                <div class="user-circle"><?php echo $inicial; ?></div>
                <?php if ($es_admin): ?>
                    <a href="crear_evento.php" class="icon-add"><i class="fas fa-plus-circle"></i></a>
                <?php endif; ?>
                <a href="../Controller/UserController.php?action=logout" class="icon-logout"><i class="fas fa-sign-out-alt"></i></a>
            <?php else: ?>
                <a href="login.php" class="btn-login">LOGIN</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="container">
        <div class="section-header">
            <h2 class="section-title-line"><?php echo htmlspecialchars($evento['artista']); ?></h2>
        </div>

        <div class="paginacion-container tabs-navegacion">
            <a href="infoevento.php?id=<?php echo $id_evento; ?>" class="pag-link active">INFORMACIÓN DEL EVENTO</a>
            <a href="infoartista.php?id=<?php echo $id_evento; ?>" class="pag-link">INFORMACIÓN DEL ARTISTA</a>
        </div>

        <div class="evento-row tarjeta-info-evento">
            
            <div class="img-container">
                <img src="../assets/img/<?php echo $evento['imagen']; ?>" alt="Portada Evento">
            </div>

            <div class="detalles-evento-header">
                <p class="fecha-badge">
                    <?php echo htmlspecialchars($evento['ubicacion']); ?> | 
                    <?php echo date('D, d M Y', strtotime($evento['fecha_evento'])); ?>
                </p>
            </div>

            <div class="flex-info-mapa">
                <div class="info-principal">
                    <h3 class="titulo-dorado">Ubicación del Recinto</h3>
                    <p class="texto-blanco">
                        <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($evento['ubicacion']); ?><br>
                        <?php echo htmlspecialchars($evento['localidad']); ?>, España
                    </p>
                    <p class="texto-gris">Apertura de puertas: <?php echo htmlspecialchars($evento['hora']); ?></p>
                </div>

                <div class="mapa-container">
                    <iframe 
                        width="100%" 
                        height="250" 
                        frameborder="0" 
                        src="https://www.google.com/maps/embed/v1/place?key=TU_API_KEY&q=<?php echo urlencode($evento['ubicacion'] . ' ' . $evento['localidad']); ?>" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </main>

    <footer class="simple-footer">
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
            </div>
            <p class="copyright">© 2026 NightFest. PREMIUM NIGHTLIFE EXPERIENCES. <br> Johan & Carolina.</p>
        </div>
    </footer>

</body>
</html>