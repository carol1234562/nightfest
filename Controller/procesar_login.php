<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Credenciales de administrador (Prueba)
    if($email == "admin@nightfest.com" && $password == "1234") {
        $_SESSION['user_name'] = "Admin";
        $_SESSION['user_email'] = $email; // Esto activa el menú "Mis Eventos"
        header("Location: inicio1.php");
        exit();
    } 
    // Usuario normal (Prueba)
    elseif($email == "usuario@nightfest.com" && $password == "1234") {
        $_SESSION['user_name'] = "Cliente";
        $_SESSION['user_email'] = $email;
        header("Location: inicio1.php");
        exit();
    }
    else {
        header("Location: login.php?error=1");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}