<?php
session_start();

// Identificación de usuario 
$is_logged = isset($_SESSION['user_id']);
$es_admin = ($is_logged && $_SESSION['rol'] === 'admin');

// Lógica de destino para secciones privadas
$destino_privado = $is_logged ? "reservar.php" : "login.php";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NightFest - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/inicio1.css">


    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body id="inicio">
    <div id="welcome-modal">
        <div class="modal-content">
            <h2 style="color:#D4AF37">¡BIENVENIDOS A NIGHTFEST!</h2>
            <p style="margin: 15px 0;">Proyecto por Johan Agreda y Carolina Solorzano.</p>
            <button id="close-welcome" style="background:#D4AF37; border:none; padding:10px 20px; cursor:pointer; font-weight:bold; border-radius:5px;">ENTRAR</button>
        </div>
    </div>

    <div id="cookie-banner">
        <span>NightFest utiliza cookies para mejorar tu experiencia. ¿Aceptas?</span>
        <button id="accept-cookies">ACEPTAR</button>
    </div>

    <header class="nf-header-main">
    <div class="nf-logo-side">
        <a href="inicio1.php">
            <img src="../assets/img/logo.png" alt="NightFest Logo">
        </a>
    </div>

    <nav class="nf-nav">
        <ul>
            <li><a href="inicio1.php" class="active">HOME</a></li>
            <li><a href="destacados_page.php">DESTACADOS</a></li>
            <li><a href="<?php echo $is_logged ? 'discotecas.php' : 'login.php'; ?>">DISCOTECAS</a></li>
            <li><a href="<?php echo $is_logged ? 'bares.php' : 'login.php'; ?>">BARES</a></li>
            <li><a href="<?php echo $is_logged ? 'festivales.php' : 'login.php'; ?>">FESTIVALES</a></li>
            <li><a href="<?php echo $is_logged ? 'restaurantes.php' : 'login.php'; ?>">RESTAURANTES</a></li>
            <?php if ($es_admin): ?>
                <li><a href="mis_eventos.php" class="btn-mis-eventos">MIS EVENTOS</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="nf-user-controls">
        <?php if ($is_logged): ?>
            <a href="perfil.php">
                <div class="user-circle"><?php echo $inicial; ?></div>
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
            <a href="login.php" class="nf-nav a" style="margin-right: 15px;">Iniciar Sesión</a>
            <a href="registro_estandar.php" class="btn-mis-eventos">Registrarse</a>
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
     
       <section class="section-map">
    <h2 class="section-title">Cerca de ti</h2>
    <div class="map-wrapper">
        <div id="map-container"></div>
        <button id="btn-recenter">
            <i class="fas fa-location-arrow"></i> MI UBICACIÓN
        </button>
    </div>
</section>
        <section class="section-bottom">
             <h2 class="section-title">Discotecas</h2>
            <div class="clubs-grid">
                <div class="club-card">
                    <img src="https://images.unsplash.com/photo-1566737236500-c8ac43014a67?auto=format&fit=crop&w=400&q=80">
                    <div class="club-info">
                        <h4>SUTTON</h4>
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card">
                    <img src="https://images.unsplash.com/photo-1545128485-c400e7702796?auto=format&fit=crop&w=400&q=80">
                    <div class="club-info">
                        <h4>PACHA</h4>
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card third-item">
                    <img src="https://images.unsplash.com/photo-1598387181032-a3103a2db5b3?auto=format&fit=crop&w=400&q=80">
                    <div class="club-info">
                        <h4>SAOKO</h4>
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
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
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card">
                    <img src="https://i.etsystatic.com/37167070/r/il/7382dc/4585963861/il_570xN.4585963861_7zi0.jpg">
                    <div class="club-info">
                        <h4>NEON BAR</h4>
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card third-item">
                    <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/06/e6/28/1a/opium-mar-club.jpg?w=1200&h=-1&s=1">
                    <div class="club-info">
                        <h4>OPIUM BAR</h4>
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
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
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMmKfrEezCa8xnuyy5eSxAjH6L-ptWErxtxw&s">
                    <div class="club-info">
                        <h4>SONAR 2026</h4>
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card third-item">
                    <img src="https://youbarcelona.com/uploads/images/c/sala-apolo-barcelona-rock/original.jpg">
                    <div class="club-info">
                        <h4>BARCELONA ROCK</h4>
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
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
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card">
                    <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/29/97/65/0a/caption.jpg?w=900&h=500&s=1">
                    <div class="club-info">
                        <h4>HARD ROCK CAFE</h4>
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
                    </div>
                </div>
                <div class="club-card third-item">
                    <img src="https://cdn.thefork.com/tf-lab/image/upload/w_500,h_500,c_fill,q_auto,f_auto,g_auto:subject/restaurant/765beae9-f2d2-413d-ad33-9cb3a8a1b588/dd5fe68f-4943-430c-ae0d-946d73c6cfbe.jpg">
                    <div class="club-info">
                        <h4>ABaC</h4>
                        <a href="<?php echo $destino_privado; ?>" class="btn">Más información</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="slider-section">
            <h2 class="section-title">Galería NightFest</h2>
        <div class="slider-galeria">
            <div class="slick-box">
                <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=500" alt="G1">
            </div>
            <div class="slick-box">
                <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=500" alt="G2">
            </div>
            <div class="slick-box">
                <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=500" alt="G3">
            </div>
            <div class="slick-box">
                <img src="https://images.ecestaticos.com/hpVN2sFeMh4Ryku5yiRFyH9o7VY=/40x9:1367x1004/1200x900/filters:fill(white):format(jpg)/f.elconfidencial.com%2Foriginal%2Fcbe%2F472%2F961%2Fcbe472961f53a4a238bf493f79d42e51.jpg" alt="G4">
            </div>
            </div>
        </section>

        <section class="slider-section">
            <h2 class="section-title">Nuestros Promotores</h2>
            <div class="slider-promotores">
                <div class="promotor-item"><h3>BALUARD</h3><p>Techno Events</p></div>
                <div class="promotor-item"><h3>MAINLINE</h3><p>Electronic Label</p></div>
                <div class="promotor-item"><h3>SHOKO</h3><p>VIP Experience</p></div>
                <div class="promotor-item"><h3>LIVE NATION</h3><p>World Tours</p></div>
            </div>
        </section>

    </main>

    <footer class="main-footer">
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
            <span class="divider">|</span>
            <a href="#">Ayuda</a>
        </div>

        <p class="copyright">© 2026 NightFest. Johan & Carolina.</p>
    </div>
</footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="../assets/css/jquery.js"></script>
    <script>
window.onload = function() {
    console.log("Cargando mapa NightFest...");
    
    try {
        // 1. Inicialización del mapa centrado en Barcelona
        var map = L.map('map-container').setView([41.3851, 2.1734], 14);

        // 2. Capa Oscura Premium (CartoDB Dark Matter)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap &copy; CARTO',
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        // 3. Configuración del Icono Dorado (Toque NightFest)
        var goldIcon = L.divIcon({
            className: 'gold-marker', // Asegúrate de tener el CSS que definimos antes
            iconSize: [12, 12],
            iconAnchor: [6, 6]
        });

        // 4. Base de datos de locales (Discotecas y Bares)
        var locales = [
            { name: "SUTTON", lat: 41.3965, lng: 2.1523, type: "Discoteca" },
            { name: "PACHA", lat: 41.3831, lng: 2.1973, type: "Discoteca" },
            { name: "OPIUM", lat: 41.3842, lng: 2.1965, type: "Discoteca" },
            { name: "REY DE COPAS", lat: 41.3802, lng: 2.1754, type: "Bar" },
            { name: "DOWNTOWN", lat: 41.3731, lng: 2.1465, type: "Discoteca" },
            { name: "NEON BAR", lat: 41.3815, lng: 2.1720, type: "Bar" }
        ];

        // 5. Añadir marcadores al mapa
        locales.forEach(function(local) {
            L.marker([local.lat, local.lng], { icon: goldIcon }).addTo(map)
                .bindPopup(`
                    <div style="text-align:center; font-family: 'Montserrat', sans-serif;">
                        <strong style="color:#D4AF37; font-size:14px;">${local.name}</strong><br>
                        <span style="color:#666; font-size:11px;">${local.type}</span><br>
                        <a href="reservar.php" style="
                            display:inline-block; 
                            margin-top:8px; 
                            padding:6px 12px; 
                            background:#D4AF37; 
                            color:white; 
                            text-decoration:none; 
                            border-radius:4px; 
                            font-weight:bold; 
                            font-size:10px;
                        ">RESERVAR MESA</a>
                    </div>
                `);
        });

        // 6. Función para el botón "Mi Ubicación"
        document.getElementById('btn-recenter').onclick = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latlng = [position.coords.latitude, position.coords.longitude];
                    
                    // Marcador especial para el usuario (puedes diferenciarlo)
                    L.circleMarker(latlng, {
                        radius: 8,
                        fillColor: "#fff",
                        color: "#D4AF37",
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(map).bindPopup("<b>Estás aquí</b>").openPopup();

                    map.flyTo(latlng, 15);
                });
            }
        };

        // 7. Forzar renderizado final (Corrección image_49c5b8.jpg)
        setTimeout(function() {
            map.invalidateSize();
            console.log("Mapa renderizado correctamente con iconos dorados.");
        }, 500);

    } catch (e) {
        console.error("Error crítico en el script del mapa:", e);
    }
};
</script>

</body>
</html>