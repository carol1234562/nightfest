<?php
session_start();

// 1. Definición de variables de estado
$is_logged = isset($_SESSION['user_id']);

// CORRECCIÓN: Definir $es_admin para que no dé error en el nav
$es_admin = ($is_logged && isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');

// 2. Inicial del nombre para el avatar
$inicial = ($is_logged && isset($_SESSION['user_name'])) ? strtoupper(substr($_SESSION['user_name'], 0, 1)) : "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>NightFest | Crónica de la Noche</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/destacados.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="news-layout">
    
     <header class="main-header">
    <div class="header-left">
        <a href="inicio1.php">
            <img src="../assets/img/logo.png" class="logo-medium" alt="NightFest Logo">
        </a>
    </div>

    <nav class="nav-menu">
    <a href="inicio1.php">HOME</a>
    <a href="destacados_page.php" class="active">DESTACADOS</a>
    
    <a href="<?= $is_logged ? 'discotecas.php' : 'login.php' ?>">DISCOTECAS</a>
    <a href="<?= $is_logged ? 'bares.php' : 'login.php' ?>">BARES</a>
    <a href="<?= $is_logged ? 'festivales.php' : 'login.php' ?>">FESTIVALES</a>
    <a href="<?= $is_logged ? 'restaurantes.php' : 'login.php' ?>">RESTAURANTES</a>
    
    <?php if ($es_admin): ?>
        <a href="mis_eventos.php" class="btn-mis-eventos">MIS EVENTOS</a>
    <?php endif; ?>
</nav>

    <div class="auth-buttons">
        <?php if ($is_logged): ?>
            <a href="perfil.php" title="Mi Perfil">
                <div class="user-circle"><?php echo htmlspecialchars($inicial); ?></div>
            </a>
            
            <?php if ($es_admin): ?>
                <a href="crear_evento.php" title="Crear Evento">
                    <i class="fas fa-plus icon-add"></i>
                </a>
            <?php endif; ?>

            <a href="../Controller/UserController.php?action=logout" title="Cerrar Sesión">
                <i class="fas fa-sign-out-alt icon-logout"></i>
            </a>
        <?php else: ?>
            <a href="login.php" class="btn-login" style="margin-right: 15px;">Iniciar Sesión</a>
            <a href="registro_estandar.php" class="btn-register">Registrarse</a>
        <?php endif; ?>
    </div>
</header>

    <main class="container">
        <header class="page-intro">
            <h1 class="main-title">Cartelera de la Semana</h1>
            <p class="date">Barcelona, <?php echo date('d \d\e F, Y'); ?></p>
        </header>

        <section class="news-grid">
            
            <article class="news-card">
                <div class="news-image">
                    <img src="https://youbarcelona.com/uploads/images/c/opium%20barcelona%20sala%206/original.jpg" alt="Opium">
                </div>
                <div class="news-content">
                    <span class="category">DISCOTECA</span>
                    <h3>OPIUM: EL EPICENTRO DEL LUJO</h3>
                    <p>La combinación perfecta de restaurante, bar y club frente al mar. Una experiencia imprescindible en la costa barcelonesa.</p>
                    <a href="#" class="read-more">Leer crónica →</a>
                </div>
            </article>

            <article class="news-card">
                <div class="news-image">
                    <img src="https://youbarcelona.com/uploads/images/c/pacha%20barcelona%20entrada%203/400x300.webp" alt="Pacha">
                </div>
                <div class="news-content">
                    <span class="category">URBANO</span>
                    <h3>PACHA: RITMOS QUE NO DESCANSAN</h3>
                    <p>Elegancia y ritmos latinos con sonido de última generación. Un clásico que se reinventa cada noche.</p>
                    <a href="#" class="read-more">Leer crónica →</a>
                </div>
            </article>

            <article class="news-card">
                <div class="news-image">
                    <img src="https://i.blogs.es/e084e0/paradiso/840_560.jpg" alt="Paradiso">
                </div>
                <div class="news-content">
                    <span class="category">COCTELERÍA</span>
                    <h3>PARADISO: EL SECRETO MEJOR GUARDADO</h3>
                    <p>Coctelería conceptual tras una puerta de nevera. Descubre por qué es considerado uno de los mejores bares del mundo.</p>
                    <a href="#" class="read-more">Leer crónica →</a>
                </div>
            </article>

        </section>
    </main>

    <footer class="main-footer">
        <p class="copyright">© 2026 NightFest Informativo. Todos los derechos reservados.</p>
    </footer>
</body>
</html>