<?php
session_start();

// identificacion de usuario 
$is_logged = isset($_SESSION['user_id']);
$es_admin = ($is_logged && $_SESSION['rol'] === 'admin');

$destino = $is_logged ? "reservar.php" : "login.php";

// inicial 
$inicial = "";
if ($is_logged) {
    $inicial = strtoupper(substr($_SESSION['user_name'], 0, 1));
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NightFest - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/STYLE1.css">
</head>

<body id="inicio">

    <header class="main-header">
        <div class="header-left">
            <a href="inicio1.php">
                <img src="../assets/img/logoNight.png" class="logo" alt="NightFest Logo">
            </a>
        </div>

        <nav class="nav-menu">
            <a href="inicio1.php" class="active">HOME</a>
            <a href="nightfest.php">DESTACADOS</a>
            <a href="discotecas.php">DISCOTECAS</a>
            <a href="bares.php">BARES</a>
            <a href="festivales.php">FESTIVALES</a>
            <a href="restaurantes.php">RESTAURANTES</a>

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

                        <a href="../Controller/logout.php" class="btn-logout-icon" title="Cerrar Sesión">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn-login">Iniciar Sesión</a>
                <a href="registro.html" class="btn-register">Registrarse</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="container">
        <section class="section-top">
            <h2 class="section-title">Destacados</h2>
            <div class="hero-container">
                <div class="hero-item">
                    <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=800&q=80" alt="Duro">
                    <div class="overlay-info">
                        <h1>DURO</h1>
                        <p>18 de nov. 2023 / 50€</p>
                    </div>
                </div>
                <div class="hero-sidebar">
                    <div class="hero-item">
                        <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/06/e6/28/1a/opium-mar-club.jpg?w=1200&h=-1&s=1" alt="Opium">
                        <div class="overlay-info">
                            <h2>OPIUM - GALA</h2>
                            <p>17 de nov / 25€</p>
                        </div>
                    </div>
                    <div class="hero-item">
                        <img src="https://youbarcelona.com/uploads/images/c/downtown%20barcelona%20club%20gente%202/400x300.webp?v=63811631314" alt="Downtown">
                        <div class="overlay-info">
                            <h2>DOWN TOWN</h2>
                            <p>27 de nov / 25€</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-bottom">
            <h2 class="section-title">Discotecas</h2>
            <div class="clubs-grid">
                <div class="club-card">
                    <img src="https://images.unsplash.com/photo-1566737236500-c8ac43014a67?auto=format&fit=crop&w=400&q=80">
                    <div class="club-info">
                        <h4>SUTTON</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card">
                    <img src="https://images.unsplash.com/photo-1545128485-c400e7702796?auto=format&fit=crop&w=400&q=80">
                    <div class="club-info">
                        <h4>PACHA</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card third-item">
                    <img src="https://images.unsplash.com/photo-1598387181032-a3103a2db5b3?auto=format&fit=crop&w=400&q=80">
                    <div class="club-info">
                        <h4>SAOKO</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-bottom">
            <h2 class="section-title">Bares</h2>
            <div class="clubs-grid">
                <div class="club-card">
                    <img src="https://privateaser-media.s3.eu-west-1.amazonaws.com/etab_photos/51437/original/427278.jpg">
                    <div class="club-info">
                        <h4>REY DE COPAS</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card">
                    <img src="https://i.etsystatic.com/37167070/r/il/7382dc/4585963861/il_570xN.4585963861_7zi0.jpg">
                    <div class="club-info">
                        <h4>NEON BAR</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card third-item">
                    <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/06/e6/28/1a/opium-mar-club.jpg?w=1200&h=-1&s=1">
                    <div class="club-info">
                        <h4>OPIUM BAR</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-bottom">
            <h2 class="section-title">FESTIVALES</h2>
            <div class="clubs-grid">
                <div class="club-card">
                    <img src="https://wololosound.com/wp-content/uploads/468153119_18030427481409963_1982800582124372713_n.jpg">
                    <div class="club-info">
                        <h4>DURO</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMmKfrEezCa8xnuyy5eSxAjH6L-ptWErxtxw&s">
                    <div class="club-info">
                        <h4>SONAR 2026</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card third-item">
                    <img src="https://youbarcelona.com/uploads/images/c/sala-apolo-barcelona-rock/original.jpg">
                    <div class="club-info">
                        <h4>BARCELONA ROCK</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-bottom">
            <h2 class="section-title">RESTAURANTES</h2>
            <div class="clubs-grid">
                <div class="club-card">
                    <img src="https://img.carta.menu/storage/media/company_gallery/9355408/conversions/contribution_gallery.jpg">
                    <div class="club-info">
                        <h4>TAGLIATELLA</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card">
                    <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/29/97/65/0a/caption.jpg?w=900&h=500&s=1">
                    <div class="club-info">
                        <h4>HARD ROCK CAFE</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card third-item">
                    <img src="https://cdn.thefork.com/tf-lab/image/upload/w_500,h_500,c_fill,q_auto,f_auto,g_auto:subject/restaurant/765beae9-f2d2-413d-ad33-9cb3a8a1b588/dd5fe68f-4943-430c-ae0d-946d73c6cfbe.jpg">
                    <div class="club-info">
                        <h4>ABaC</h4>
                        <a href="<?php echo $destino; ?>" class="btn">Más información</a>
                    </div>
                </div>
            </div>
        </section>
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
            <p class="copyright">© 2026 NightFest. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>