<?php

class UserController {
    private $connection;

    public function __construct() {
        // --- CONFIGURACIÓN DE CONEXIÓN ---
        $host = "localhost";
        $user = "root";      // Cambiar si usas otro usuario
        $pass = "";          // Cambiar si tienes contraseña en MySQL
        $db   = "tu_db";

        $this->connection = new mysqli($host, $user, $pass, $db);

        if ($this->connection->connect_error) {
            die("Error de conexión: " . $this->connection->connect_error);
        }
        
        $this->connection->set_charset("utf8mb4");
    }

    // --- MÉTODO: LOGIN ---
    public function login() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $this->connection->real_escape_string(trim($_POST['email']));
            $password = $_POST['password'];

            $sql = "SELECT id, nombre, email, password, rol FROM usuarios WHERE email = '$email'";
            $result = $this->connection->query($sql);

            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // Comparamos la clave escrita con el hash de la BD
                if (($password === $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['nombre']  = $user['nombre'];
                    $_SESSION['rol']     = $user['rol']; 
                    header("Location: ../view/perfil.php");
                    exit();
                }
            }
            header("Location: ../view/login.php?error=Credenciales incorrectas");
            exit();
        }
    }

    // --- MÉTODO: REGISTRO ---
    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Limpieza de datos
            $nombre = $this->connection->real_escape_string(trim($_POST['nombre']));
            $email  = $this->connection->real_escape_string(trim($_POST['email']));
            $pass   = $_POST['password'];
            $rol_solicitado = $_POST['rol'] ?? 'estandar';
            $codigo_admin   = $_POST['admin_code'] ?? '';

            // Validaciones básicas de servidor
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../view/registro.php?error=Email no válido"); exit();
            }
            if (strlen($pass) < 6) {
                header("Location: ../view/registro.php?error=Clave muy corta"); exit();
            }

            // Lógica de Rol y Foto
            $rol_final = 'estandar';
            $nombre_foto = 'default.png';

            if ($rol_solicitado === 'admin' && $codigo_admin === "ADMIN123") {
                $rol_final = 'admin';
            }

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $nombre_foto = "perfil_" . time() . "." . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/" . $nombre_foto);
            }

            // Guardar en Base de Datos
            $passHash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nombre, email, password, rol, foto_perfil) 
                    VALUES ('$nombre', '$email', '$passHash', '$rol_final', '$nombre_foto')";

            if ($this->connection->query($sql)) {
                header("Location: ../view/login.php?success=Usuario creado correctamente");
            } else {
                header("Location: ../view/registro.php?error=El correo ya está registrado");
            }
            exit();
        }
    }

    // --- MÉTODO: LOGOUT ---
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header("Location: ../view/login.php");
        exit();
    }
} // Fin de la clase