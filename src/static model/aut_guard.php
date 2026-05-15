<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Forzar al navegador a destruir la caché de esta página
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

/**
 * Función opcional para proteger páginas que son ESTRICTAMENTE privadas 
 * (como crear_evento.php o reservar.php)
 */
function check_autenticacion() {
    if (!isset($_SESSION['user_id'])) {
        // Si no hay sesión, rebota al usuario inmediatamente al login
        header("Location: login.php");
        exit();
    }
}

/**
 * Función opcional para proteger zonas de Administrador
 */
function check_admin() {
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
        // Si no es admin, mándalo al home
        header("Location: inicio1.php");
        exit();
    }
}