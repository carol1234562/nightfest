<?php
$conexion = new mysqli("localhost", "root", "", "NightFest");

if ($conexion->connect_error) {
    die("Error de conexión");
}

$eventos_por_pagina = 8;
$max_paginas_permitidas = 10;
$total_max_eventos = 80;

$pagina_actual = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;
if ($pagina_actual > $max_paginas_permitidas) $pagina_actual = $max_paginas_permitidas;

$offset = ($pagina_actual - 1) * $eventos_por_pagina;

$sql = "SELECT * FROM (
            SELECT * FROM eventos 
            WHERE fecha_evento >= CURDATE() 
            ORDER BY fecha_evento ASC 
            LIMIT $total_max_eventos
        ) AS subconsulta 
        LIMIT $eventos_por_pagina OFFSET $offset";

$resultado = $conexion->query($sql);

$conteo_query = "SELECT COUNT(*) as total FROM (
                    SELECT id FROM eventos 
                    WHERE fecha_evento >= CURDATE() 
                    LIMIT $total_max_eventos
                ) AS temp";
$conteo_res = $conexion->query($conteo_query);
$total_eventos_validos = ($conteo_res) ? $conteo_res->fetch_assoc()['total'] : 0;
$total_paginas_reales = ceil($total_eventos_validos / $eventos_por_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NightFest - Discotecas</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/STYLE1.css">
</head>
<body id="discotecas-page">

    <header class="nf-header-main">
        <div class="nf-logo-side">
            <a href="inicio1.php">
                <img src="../assets/img/logonight.png" alt="NightFest Logo">
            </a>
        </div>

        <nav class="nf-nav">
            <ul>
                <li><a href="inicio1.php">HOME</a></li>
                <li><a href="destacados_page.php">DESTACADOS</a></li>
                <li><a href="discotecas.php" class="active">DISCOTECAS</a></li>
                <li><a href="#">BARES</a></li>
                <li><a href="#">FESTIVALES</a></li>
                <li><a href="#">RESTAURANTES</a></li>
                <li><a href="#" class="btn-mis-eventos">MIS EVENTOS</a></li>
            </ul>
        </nav>

        <div class="nf-user-controls">
            <div class="user-circle">A</div>
            <a href="registro_admin.php" class="icon-add"><i class="fas fa-plus-circle"></i></a>
            <a href="login.php" class="icon-logout"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </header>

    <main class="container">
        <div class="section-header">
            <h2 class="section-title-line">DISCOTECAS</h2>
        </div>

        <div class="eventos-cascada">
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while($row = $resultado->fetch_assoc()): ?>
                    <div class="evento-row" onclick="window.location.href='infoevento.php?id=<?php echo $row['id']; ?>'">
                        <div class="img-container">
                            <img src="../assets/img/<?php echo $row['imagen']; ?>" alt="Evento">
                        </div>
                        <div class="info-principal">
                            <span class="fecha-badge">
                                <?php echo date('D, d M', strtotime($row['fecha_evento'])); ?> | <?php echo $row['hora']; ?>
                            </span>
                            <h3><?php echo htmlspecialchars($row['artista']); ?></h3>
                            <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['ubicacion']); ?> • <?php echo htmlspecialchars($row['localidad']); ?></p>
                        </div>
                        <div class="estado-accion">
                            <span class="status-disponible"><?php echo $row['estado']; ?></span>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-data">No hay discotecas con eventos próximos.</p>
            <?php endif; ?>
        </div>

        <?php if ($total_paginas_reales > 1): ?>
        <div class="paginacion-container">
            <?php for ($i = 1; $i <= $total_paginas_reales; $i++): ?>
                <a href="?p=<?php echo $i; ?>" class="pag-link <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <div class="footer-links">
            <span>Términos</span>
            <span>Ayuda</span>
            <span>Privacidad</span>
        </div>
        <div class="footer-redes">
            <span>🎵</span>
            <span>✖</span>
            <span>📷</span>
            <span>📘</span>
        </div>
    </footer>

</body>
</html>