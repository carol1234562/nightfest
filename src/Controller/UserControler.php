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
        $nombre = $this->connection->real_escape_string(trim($_POST['nombre']));
        $email = $this->connection->real_escape_string(trim($_POST['email']));
        $pass = $_POST['password'];
        $rol_solicitado = $_POST['rol'];
        $codigo_admin = $_POST['admin_code'] ?? '';
        
        // 4.5: Validaciones de servidor
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../view/registro.php?error=Formato de email inválido"); exit();
        }
        if (strlen($pass) < 6) {
            header("Location: ../view/registro.php?error=La contraseña debe tener 6 caracteres"); exit();
        }

        // --- LÓGICA DE SEGURIDAD PARA ADMIN ---
        $rol_final = 'estandar';
        $nombre_foto = 'default.png';

        if ($rol_solicitado === 'admin') {
            // Especificación: Validar código secreto para ser admin
            if ($codigo_admin !== "ADMIN123") { // Cambia este código por el que quieras
                header("Location: ../view/registro.php?error=Código de administrador incorrecto");
                exit();
            }
            $rol_final = 'admin';

            // 2.5: Procesar Foto de Perfil
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
                $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $nombre_foto = "perfil_" . time() . "." . $extension;
                $ruta_destino = "../assets/img/" . $nombre_foto;
                
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino)) {
                    header("Location: ../view/registro.php?error=Error al subir la imagen"); exit();
                }
            }
        }

        // 2.2: Insertar en Base de Datos (con Password Hashing)
        $passHash = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre, email, password, rol, foto_perfil) 
                VALUES ('$nombre', '$email', '$passHash', '$rol_final', '$nombre_foto')";

        if ($this->connection->query($sql)) {
            // 2.3: Redirigir al login o principal con éxito
            header("Location: ../view/login.php?success=Usuario registrado como $rol_final");
        } else {
            header("Location: ../view/registro.php?error=El correo ya está registrado");
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