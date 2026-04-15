<?php

class UserController
{
    private $connection;

    public function __construct()
    {
        // --- CONFIGURACIÓN DE CONEXIÓN ---
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "NightFest"; // Coincide con tu base de datos en Workbench

        $this->connection = new mysqli($host, $user, $pass, $db);

        if ($this->connection->connect_error) {
            die("Error de conexión: " . $this->connection->connect_error);
        }

        $this->connection->set_charset("utf8mb4");
    }

    // --- MÉTODO: LOGIN ---
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $this->connection->real_escape_string(trim($_POST['email']));
            $password = trim($_POST['password']);

            $sql = "SELECT id, nombre, email, password, rol FROM usuarios WHERE email = '$email'";
            $result = $this->connection->query($sql);

            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // Verificación segura con el Hash de la base de datos
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id']   = $user['id'];
                    $_SESSION['user_name'] = $user['nombre'];
                    $_SESSION['rol']       = $user['rol'];

                    header("Location: ../view/perfil.php");
                    exit();
                }
            }
            // Si llega aquí, es que el usuario no existe o la contraseña falló
            header("Location: ../view/login.php?error=Credenciales_incorrectas");
            exit();
        }
    }

    // --- MÉTODO: REGISTRO ---
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $this->connection->real_escape_string(trim($_POST['nombre']));
            $email  = $this->connection->real_escape_string(trim($_POST['email']));
            $pass   = $_POST['password'];
            $rol_solicitado = $_POST['rol'] ?? 'estandar';
            $codigo_admin   = $_POST['admin_code'] ?? '';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../view/registro.php?error=Email_no_valido");
                exit();
            }
            if (strlen($pass) < 6) {
                header("Location: ../view/registro.php?error=Clave_muy_corta");
                exit();
            }

            $rol_final = ($rol_solicitado === 'admin' && $codigo_admin === "ADMIN123") ? 'admin' : 'estandar';
            $nombre_foto = 'default.png';

            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $nombre_foto = "perfil_" . time() . "." . $ext;
                move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/" . $nombre_foto);
            }

            $passHash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nombre, email, password, rol, foto_perfil) 
                    VALUES ('$nombre', '$email', '$passHash', '$rol_final', '$nombre_foto')";

            if ($this->connection->query($sql)) {
                header("Location: ../view/login.php?success=Usuario_creado");
            } else {
                header("Location: ../view/registro.php?error=Email_ya_registrado");
            }
            exit();
        }
    }

    // --- MÉTODO: LOGOUT ---
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header("Location: ../view/login.php");
        exit();
    }
}

// --- LÓGICA DE CONTROL DE RUTAS ---
$uc = new UserController();
$action = $_GET['action'] ?? '';

if ($action === 'logout') {
    $uc->logout();
} elseif ($action === 'register') {
    $uc->register();
} else {
    // Si la página se carga por POST sin acción, es un intento de login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uc->login();
    }
}