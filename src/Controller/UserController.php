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
        $db   = "NightFest";

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
        // Limpiamos los datos de entrada
        $email = $this->connection->real_escape_string(trim($_POST['email']));
        $password = $this->connection->real_escape_string(trim($_POST['password']));

        // Validamos Email y Password juntos en la misma consulta
        $sql = "SELECT id, nombre, email, rol FROM usuarios 
                WHERE email = '$email' AND password = '$password'";
        
        $result = $this->connection->query($sql);

        if ($result && $result->num_rows > 0) {
            // Si hay resultado, es que ambos coinciden "de la mano"
            $user = $result->fetch_assoc();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol'];

            header("Location: ../view/perfil.php");
            exit();
        } else {
            // Si falla uno o ambos, el resultado es 0 filas
            header("Location: ../view/login.php?error=Datos_Incorrectos");
            exit();
        }
    }
}

public function register() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $this->connection->real_escape_string(trim($_POST['nombre']));
        $email  = $this->connection->real_escape_string(trim($_POST['email']));
        $pass   = $this->connection->real_escape_string(trim($_POST['password']));
        
        // Guardamos la contraseña tal cual, sin password_hash
        $sql = "INSERT INTO usuarios (nombre, email, password, rol, foto_perfil) 
                VALUES ('$nombre', '$email', '$pass', 'estandar', 'default.png')";

        if ($this->connection->query($sql)) {
            header("Location: ../view/login.php?success=Registrado");
        } else {
            header("Location: ../view/registro.php?error=Error_en_registro");
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
