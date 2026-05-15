<?php

class UserController
{
    private mysqli $connection;

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

public function register()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = trim($_POST['nombre'] ?? '');
        $email  = trim($_POST['email'] ?? '');
        $pass   = trim($_POST['password'] ?? '');
        $rol    = $_POST['rol'] ?? 'estandar';

        // Hace una validación si es un formato email o no
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../view/registro_" . $rol . ".php?error=Formato de email invalido");
            exit();
        }

        // Hace otra validación que la contraseña tiene que se de minimo 6 caracteres
        if (strlen($pass) < 6) {
            header("Location: ../view/registro_" . $rol . ".php?error=La contrasena debe tener minimo 6 caracteres");
            exit();
        }

        if ($rol === 'admin') {
            $codigo = $_POST['admin_code'] ?? '';
            if ($codigo !== "admin123") {
                header("Location: ../view/registro_admin.php?error=Codigo de administrador incorrecto");
                exit();
            }
        }

        // Permite ponerse una foto de perfil solo para los que son administradores
        $nombre_foto = 'default.png';
        if ($rol === 'admin' && isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
            $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $ext_permitidas)) {
                header("Location: ../view/registro_admin.php?error=Formato de imagen no permitido. Usa jpg, png o gif");
                exit();
            }

            $nombre_foto = "perfil_" . time() . "." . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/img/" . $nombre_foto);
        }

        $stmt = $this->connection->prepare(
            "INSERT INTO usuarios (nombre, email, password, rol, foto_perfil) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $nombre, $email, $pass, $rol, $nombre_foto);

        if ($stmt->execute()) {
            // Redirige a la pagina principal si todo esta bien 
            header("Location: ../view/inicio1.php");
        } else {
            // Mensaje de error
            header("Location: ../view/registro_" . $rol . ".php?error=El correo ya esta registrado");
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
public function deleteAccount($id) {
        $id = $this->connection->real_escape_string($id);
        
        $user = $this->getUserData($id);
        if ($user && $user['foto_perfil'] !== 'default.png') {
            $rutaFoto = "../assets/img/" . $user['foto_perfil'];
            if (file_exists($rutaFoto)) {
                unlink($rutaFoto); 
            }
        }

        $sql = "DELETE FROM usuarios WHERE id = '$id'";
        if ($this->connection->query($sql)) {
            $this->logout(); 
        } else {
            header("Location: ../view/perfil.php?error=no_se_pudo_borrar");
            exit();
        }
    }

    public function actualizarPerfil($userId, $datos, $archivoFoto) {
        $db = Connection::connect(); // O como gestiones tu conexión PDO/MySQLi
        
        // 1. Mantener la foto actual por si el usuario no sube una nueva
        $sqlActual = "SELECT foto_perfil FROM usuarios WHERE id = :id";
        $stmtActual = $db->prepare($sqlActual);
        $stmtActual->execute([':id' => $userId]);
        $usuario = $stmtActual->fetch(PDO::FETCH_ASSOC);
        $nombreFotoFinal = $usuario['foto_perfil']; // Valor actual (ej: 'default.png')

        // 2. Validar si el usuario ha subido un archivo real y no hay errores
        if (isset($archivoFoto['name']) && $archivoFoto['error'] === UPLOAD_ERR_OK) {
            
            $carpeta_dest = '../View/img/'; // Ajusta la ruta para llegar a tu carpeta 'img' desde el controlador
            $extension = pathinfo($archivoFoto['name'], PATHINFO_EXTENSION);
            
            // Generar el nombre único para evitar duplicados caóticos
            $nombreFotoFinal = "perfil_" . $userId . "_" . time() . "." . $extension;
            
            // Mover el archivo temporal a la carpeta física
            if (move_uploaded_file($archivoFoto['tmp_name'], $carpeta_dest . $nombreFotoFinal)) {
                
                // OPCIONAL: Borrar la foto anterior del servidor si NO era la por defecto
                if ($usuario['foto_perfil'] !== 'default.png' && $usuario['foto_perfil'] !== 'default.jpg') {
                    $fotoAnterior = $carpeta_dest . $usuario['foto_perfil'];
                    if (file_exists($fotoAnterior)) {
                        unlink($fotoAnterior);
                    }
                }
            }
        }

        // 3. Guardar en la Base de Datos únicamente el nombre del archivo
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, foto_perfil = :foto WHERE id = :id";
        $stmt = $db->prepare($sql);
        
        return $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':email'  => $datos['email'],
            ':foto'   => $nombreFotoFinal, // Aquí se guarda el string seguro
            ':id'     => $userId
        ]);
    }
}

// --- LÓGICA DE CONTROL DE RUTAS ---
$uc = new UserController();
$action = $_GET['action'] ?? '';

if ($action === 'logout') {
    $uc->logout();
} elseif ($action === 'register') {
    $uc->register();
} elseif ($action === 'deleteAccount') {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (isset($_SESSION['user_id'])) {
        $uc->deleteAccount($_SESSION['user_id']);
    } else {
        header("Location: ../view/login.php");
    }
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uc->login();
    }
}
?>