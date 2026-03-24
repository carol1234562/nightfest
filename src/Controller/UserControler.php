<?php

class UserController {
    private $connection;

    public function __construct() {
        $this->connection = new mysqli("localhost", "tu_usuario", "tu_password", "tu_db");

        if ($this->connection->connect_error) {
            die("Error de conexión: " . $this->connection->connect_error);
        }
    }

    public function login() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $this->connection->real_escape_string($_POST['email']);
            $password = $_POST['password'];

            $sql = "SELECT id, nombre, email, password, rol FROM usuarios WHERE email = '$email'";
            $result = $this->connection->query($sql);

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['rol'] = $user['rol']; 
                    header("Location: ../view/perfil.php");
                    exit();
                }
            }
            header("Location: ../view/login.php?error=Credenciales incorrectas");
            exit();
        }
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $pass = $_POST['password'];
            $rol = $_POST['rol']; 
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../view/registro.html?error=Email no válido");
                exit();
            }
            if (strlen($pass) < 6) {
                header("Location: ../view/registro.html?error=Contraseña muy corta");
                exit();
            }

            $passHash = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$passHash', '$rol')";
            
            if ($this->connection->query($sql)) {
                header("Location: ../view/inicio1.php?success=1");
            } else {
                header("Location: ../view/registro.html?error=Error al registrar");
            }
            exit();
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../view/login.php");
        exit();
    }
}