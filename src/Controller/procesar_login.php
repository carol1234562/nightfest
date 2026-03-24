<?php
session_start();

// Habilitar errores por si algo falla internamente
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Credenciales de prueba
    $admin_user = "admin@nightfest.com";
    $admin_pass = "1234";
    
    $normal_user = "usuario@nightfest.com";
    $normal_pass = "1234";

    if ($email === $admin_user && $password === $admin_pass) {
        $_SESSION['user_name'] = "Admin";
        $_SESSION['user_email'] = $email;
        
        // SALE de Controller/ y ENTRA en view/
        header("Location: ../view/inicio1.php");
        exit();
    } 
    elseif ($email === $normal_user && $password === $normal_pass) {
        $_SESSION['user_name'] = "Cliente";
        $_SESSION['user_email'] = $email;
        
        // SALE de Controller/ y ENTRA en view/
        header("Location: ../view/inicio1.php");
        exit();
    }
    else {
        // Si fallan los datos, vuelve al login con el error
        header("Location: ../view/login.php?error=1");
        exit();
    }
} else {
    // Si intentan acceder directamente al archivo sin POST
    header("Location: ../view/login.php");
    exit();
}