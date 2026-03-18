<?php
session_start();    
// Primero recuperamos la sesión
session_unset();    
// Limpiamos todas las variables de sesión
session_destroy();  
// Destruimos la sesión por completo
header("Location: inicio1.php"); 
// Redirigimos al inicio ya como invitado
exit();
?>