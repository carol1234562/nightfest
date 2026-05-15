<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Detectar si el usuario está logueado
$is_logged = isset($_SESSION['user_id']);

// 2. Obtener el rol para saber si es admin
$es_admin = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin');

// 3. Sincronizar la foto de perfil guardada en el controlador
$foto_perfil = $_SESSION['user_photo'] ?? 'default.png';

// 4. Calcular la inicial automáticamente si no hay foto o es la por defecto
$inicial = 'U'; // Valor por defecto (Usuario)
if (isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])) {
    $inicial = strtoupper(substr($_SESSION['user_name'], 0, 1));
}
?>

<style>
/* =========================================================================
   NIGHTFEST - CSS COMPLETO DEL HEADER
   ========================================================================= */
/* Busca la clase principal de tu cabecera en header.php y déjala así */
.nf-header {
    background-color: #000000 !important; /* 🌟 Cambia cualquier color o transparencia por negro puro */
    position: relative !important;        /* Asegura que se comporte como un bloque sólido en el flujo */
    width: 100% !important;
    height: 80px;                         /* Ajusta a la altura que tengas configurada */
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 2px solid #D4AF37 !important; /* Mantiene tu elegante línea dorada divisoria */
    z-index: 9999 !important;             /* Lo pone por encima de cualquier mapa o slider al hacer scroll */
}
/* 1. CONTENEDOR PRINCIPAL */
.nf-header-main {
    background-color: #000000; /* Fondo negro puro */
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
    height: AUTO;
    box-sizing: border-box;
    width: 100%;

    /* LA LÍNEA GRUESA Y DORADA */
    border-bottom: 4px solid #D4AF37; 
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.8), 0 2px 8px rgba(225, 177, 44, 0.4);
}

/* 2. LADO IZQUIERDO: LOGO */
.nf-logo-side a img {
    height: 120px; /* Ajusta según el tamaño de tu logo */
    object-fit: contain;
    display: block;
}

/* 3. CENTRO: MENÚ DE NAVEGACIÓN */
.nf-nav ul {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 25px; /* Espaciado entre pestañas */
    align-items: center;
}

.nf-nav ul li a {
    color: #ffffff !important; /* Por defecto nacen blancos */
    text-decoration: none;
    font-family: 'Arial', sans-serif; /* Cambia por tu fuente corporativa */
    font-weight: bold;
    font-size: 16px;
    text-transform: uppercase;
    /* Transición suave para el efecto de color al pasar el ratón */
    transition: color 0.2s ease-in-out; 
    letter-spacing: 0.5px;
}

/* EFECTO HOVER: Al pasar el ratón se vuelve dorado, al quitarlo vuelve a blanco */
.nf-nav ul li a:hover {
    color: #D4AF37 !important; 
}

/* PÁGINA ACTIVA: Se queda fijo en dorado */
.nf-nav ul li a.active {
    color: #D4AF37 !important; 
}
.nf-user-controls a {
    text-decoration: none !important; /* Elimina cualquier línea azul o subrayado de los iconos/avatar */
    display: inline-flex;
    align-items: center;
}

/* 4. LADO DERECHO: CONTROLES DE USUARIO (AUTH) */
.nf-user-controls {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-right: 20px;
}

/* Enlace de "Iniciar Sesión" (Blanco por defecto, dorado en hover) */
.nf-user-controls a.nf-nav.a {
    color: #ffffff !important;
    text-decoration: none;
    font-weight: bold;
    font-size: 16px;
    transition: color 0.2s ease-in-out;
}

.nf-user-controls a.nf-nav.a:hover {
    color: #D4AF37 !important;
}

/* Botón llamativo ("Registrarse" o "Mis Eventos") */
.btn-mis-eventos {
    background-color: #D4AF37; /* Fondo dorado fijo */
    color: #000000 !important;  /* Texto negro para contrastar */
    padding: 8px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
    transition: background-color 0.2s ease;
}

.btn-mis-eventos:hover {
    background-color: #c79a1e; /* Dorado más oscuro al pasar el cursor */
}

/* 5. AVATAR EN MINIATURA DEL USUARIO LOGUEADO */
.user-avatar-container {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.user-avatar-container:hover {
    transform: scale(1.1); /* Efecto zoom sutil al pasar el ratón por el avatar */
}

/* Imagen circular real */
.user-avatar-mini {
    width: 100%;
    height: 100%;
    border-radius: 50%; /* Círculo perfecto */
    object-fit: cover;  /* Evita distorsiones si la foto no es cuadrada */
    border: 2px solid #D4AF37; /* Borde dorado que combina con la marca */
    box-shadow: 0 0 8px rgba(212, 175, 55, 0.4); /* Destello dorado suave */
    transition: transform 0.2s ease;
}

.user-avatar-mini:hover {
    transform: scale(1.05); /* Efecto zoom sutil al pasar el ratón */
}

/* Círculo con inicial (Respaldo por si no tiene foto) */
.user-circle-fallback {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: #D4AF37; /* Fondo dorado */
    color: #000000;            /* Letra inicial negra */
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 16px;
    text-transform: uppercase;
    box-shadow: 0 0 8px rgba(212, 175, 55, 0.3);
}
.icon-logout {
    color: #ffffff;
    font-size: 20px;   /* Subimos el tamaño del icono de salida (de 18px a 20px) para que combine con el avatar */
    cursor: pointer;
    padding: 5px;      /* Crea un área de clic más cómoda */
    transition: color 0.2s ease, transform 0.2s ease;
}

/* 6. ICONOS DE ACCIÓN RAPIDA (FontAwesome: Añadir Evento / Logout) */
.icon-add, .icon-logout {
    color: #ffffff;
    font-size: 18px;
    cursor: pointer;
    transition: color 0.2s ease, transform 0.2s ease;
}

/* El icono "+" se vuelve verde al hover */
.icon-add:hover {
    color: #4cd137 !important;
    transform: scale(1.15);
}

/* El icono de salida se vuelve rojo al hover */
.icon-logout:hover {
    color: #e84118 !important;
    transform: scale(1.15);
}
    </style>

<!-- HEADER -->
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
                <li><a href="<?= $is_logged ? 'discotecas.php' : 'login.php' ?>">DISCOTECAS</a></li>
                <li><a href="<?= $is_logged ? 'bares.php' : 'login.php' ?>">BARES</a></li>
                <li><a href="<?= $is_logged ? 'festivales.php' : 'login.php' ?>">FESTIVALES</a></li>
                <li><a href="<?= $is_logged ? 'restaurantes.php' : 'login.php' ?>">RESTAURANTES</a></li>
                <?php if ($es_admin): ?>
                    <li><a href="mis_eventos.php" class="btn-mis-eventos">MIS EVENTOS</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="nf-user-controls">
    <?php if ($is_logged): ?>
        
        <a href="perfil.php" title="Mi Perfil">
    <div class="user-avatar-container">
        <?php 
        // Forzamos la comprobación: si tiene sesión y no es la palabra default de texto plano
        if (isset($_SESSION['user_photo']) && !empty($_SESSION['user_photo']) && $_SESSION['user_photo'] !== 'default.png'): 
            // Limpiamos el nombre del archivo
            $archivo_foto = trim($_SESSION['user_photo']);
        ?>
            <img src="../assets/img/uploads/<?= htmlspecialchars($archivo_foto, ENT_QUOTES, 'UTF-8') ?>" 
                 alt="Perfil" 
                 class="user-avatar-mini"
                 onerror="this.style.display='none'; document.getElementById('fallback-emergencia').style.display='flex';">
            
            <div id="fallback-emergencia" class="user-circle-fallback" style="display: none;"><?= htmlspecialchars($inicial, ENT_QUOTES, 'UTF-8') ?></div>
            
        <?php else: ?>
            <div class="user-circle-fallback"><?= htmlspecialchars($inicial, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>
</a>
        
        <?php if ($es_admin): ?>
            <a href="crear_evento.php" title="Crear Evento" style="margin-left: 10px;">
                <i class="fas fa-plus icon-add"></i>
            </a>
        <?php endif; ?>
        
        <a href="../Controller/UserController.php?action=logout" title="Cerrar Sesión" style="margin-left: 10px;">
            <i class="fas fa-sign-out-alt icon-logout"></i>
        </a>

    <?php else: ?>
        <a href="login.php" class="nf-nav a" style="margin-right: 15px;">Iniciar Sesión</a>
        <a href="registro_estandar.php" class="btn-mis-eventos">Registrarse</a>
    <?php endif; ?>
</div>
    </header>

    