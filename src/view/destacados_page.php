<?php
session_start();

// Identificación de usuario 
$is_logged = isset($_SESSION['user_id']);
$es_admin = ($is_logged && $_SESSION['rol'] === 'admin');

// Inicial del nombre para el avatar
$inicial = "";
if ($is_logged && isset($_SESSION['user_name'])) {
    $inicial = strtoupper(substr($_SESSION['user_name'], 0, 1));
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>NightFest | Destacados y Experiencias</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/destacados_page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="home-page">
    
    <header class="main-header">
        <div class="header-left">
            <a href="inicio1.php">
                <img src="../assets/img/logoNight.png" class="logo" alt="NightFest Logo">
            </a>
        </div>

        <nav class="nav-menu">
            <a href="inicio1.php">HOME</a>
            <a href="destacados_page.php" class="active">DESTACADOS</a>
            <a href="<?php echo $is_logged ? 'discotecas.php' : 'login.php'; ?>">DISCOTECAS</a>
            <a href="<?php echo $is_logged ? 'bares.php' : 'login.php'; ?>">BARES</a>
            <a href="<?php echo $is_logged ? 'festivales.php' : 'login.php'; ?>">FESTIVALES</a>
            <a href="<?php echo $is_logged ? 'restaurantes.php' : 'login.php'; ?>">RESTAURANTES</a>

            <?php if ($es_admin): ?>
                <a href="mis_eventos.php" class="admin-link">MIS EVENTOS</a>
            <?php endif; ?>
        </nav>

        <div class="auth-buttons">
            <?php if ($is_logged): ?>
                <div class="user-panel">
                    <a href="perfil.php" class="user-avatar-link">
                        <div class="user-avatar"><?php echo $inicial; ?></div>
                    </a>

                    <div class="user-actions">
                        <?php if ($es_admin): ?>
                            <a href="crear_evento.php" class="icon-plus" title="Crear Evento">
                                <i class="fas fa-plus"></i>
                            </a>
                        <?php endif; ?>

                        <a href="../Controller/UserController.php?action=logout" class="btn-logout-icon" title="Cerrar Sesión">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn-login">Iniciar Sesión</a>
                <a href="registro.php" class="btn-register">Registrarse</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="container">
        
        <div class="section-intro">
            <h2 class="section-title">Cartelera</h2>
        </div>

        <div class="clubs-grid">
            
            <article class="club-card">
                <div class="card-img-wrapper">
                    <img src="https://youbarcelona.com/uploads/images/c/opium%20barcelona%20sala%206/original.jpg" alt="Opium Barcelona">
                </div>
                <div class="club-info">
                    <h4>OPIUM: MAGNIFICENT NIGHTS</h4>
                    <p>La combinación perfecta de restaurante, bar y club frente al mar. DJ set internacional con lo mejor del House y R&B comercial.</p>
                </div>
            </article>

            <article class="club-card">
                <div class="card-img-wrapper">
                    <img src="https://youbarcelona.com/uploads/images/c/pacha%20barcelona%20entrada%203/400x300.webp?v=63787259575" alt="Pacha Barcelona">
                </div>
                <div class="club-info">
                    <h4>PACHA: PURE VIBES</h4>
                    <p>Elegancia y ritmos latinos/urbanos. Un sistema de sonido de última generación garantizado para los amantes del baile.</p>
                </div>
            </article>

            <article class="club-card">
                <div class="card-img-wrapper">
                    <img src="https://i.blogs.es/e084e0/paradiso/840_560.jpg" alt="Speakeasy Bar">
                </div>
                <div class="club-info">
                    <h4>PARADISO: COCTELERÍA OCULTA</h4>
                    <p>Cócteles conceptuales tras una puerta de nevera. Mística, sorpresas visuales y sabores innovadores.</p>
                </div>
            </article>

            <article class="club-card">
                <div class="card-img-wrapper">
                    <img src="https://estaticos.esmadrid.com/cdn/farfuture/r7njFidxx_kgdjSlnhNyKRkNlNjz4ESYIx6mNkdV0hY/mtime:1623164776/sites/default/files/recursosturisticos/noche/360_terraza_y_sky_bar_de_madrid_al_cielo_7.jpg" alt="Rooftop Bar">
                </div>
                <div class="club-info">
                    <h4>SKYBAR: VISTAS 360°</h4>
                    <p>Punto de encuentro para el 'Afterwork' con la mejor vista del skyline y música Chill-out.</p>
                </div>
            </article>

            <article class="club-card">
                <div class="card-img-wrapper">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPzM503_pHSR7elQZ809mFiV3Ln6TMp3mVWw&s" alt="Sonar Festival">
                </div>
                <div class="club-info">
                    <h4>SONAR: MÚSICA Y TECNOLOGÍA</h4>
                    <p>Referencia para la música electrónica y el arte digital. Una gran fiesta visual y sonora nocturna.</p>
                </div>
            </article>

            <article class="club-card">
                <div class="card-img-wrapper">
                    <img src="https://offloadmedia.feverup.com/barcelonasecreta.com/wp-content/uploads/2022/09/08091124/brunch-in-thepark-3-1024x683.jpg" alt="Brunch-In The Park">
                </div>
                <div class="club-info">
                    <h4>BRUNCH-IN THE PARK</h4>
                    <p>Evento al aire libre con DJs internacionales y gastronomía en la montaña de Montjuïc.</p>
                </div>
            </article>

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
            <p class="copyright">© 2026 NightFest. PREMIUM NIGHTLIFE EXPERIENCES.</p>
        </div>
    </footer>

</body>
</html>