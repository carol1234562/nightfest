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
        $db   = "nightfest";

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
            $password = $this->connection->real_escape_string(trim($_POST['password']));

            $sql = "SELECT id, nombre, email, rol FROM usuarios 
                    WHERE email = '$email' AND password = '$password'";
            
            $result = $this->connection->query($sql);

            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['rol'] = $user['rol'];

                header("Location: ../view/inicio1.php");
                exit();
            } else {
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
        $rol_solicitado = $_POST['rol'] ?? 'estandar';
        $codigo_admin   = $_POST['admin_code'] ?? '';

        $rol_final = 'estandar';
        if ($rol_solicitado === 'admin' && $codigo_admin === "ADMIN123") {
            $rol_final = 'admin';
        }

        $nombre_foto = 'default.png';
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $nombre_foto = "perfil_" . time() . "." . $ext;
            // Asegúrate de que esta carpeta exista
            move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/" . $nombre_foto);
        }

        $sql = "INSERT INTO usuarios (nombre, email, password, rol, foto_perfil) 
                VALUES ('$nombre', '$email', '$pass', '$rol_final', '$nombre_foto')";

        if ($this->connection->query($sql)) {
            header("Location: ../view/login.php?success=Cuenta_creada_exitosamente");
        } else {
            header("Location: ../view/registro.php?error=El_correo_ya_existe_o_error_interno");
        }
        exit();
    }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header("Location: ../view/inicio1.php");
        exit();
    }

public function getUserData($id) {
        $id = $this->connection->real_escape_string($id);
        $sql = "SELECT * FROM usuarios WHERE id = '$id'";
        $resultado = $this->connection->query($sql);
        return $resultado->fetch_assoc();
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uc->login();
    }
}

?>