<?php
namespace App\Controllers;

require_once __DIR__ . '/../../conexion.php';

class AuthController
{
    // Función que realiza el Login
    public static function login()
{
    session_start();
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_usuario = $_POST['username'] ?? '';
        $contraseña = $_POST['password'] ?? '';

        if (empty($nombre_usuario) || empty($contraseña)) {
            $_SESSION['error_message'] = "Por favor llena todos los campos.";
            header("Location: login.php");
            exit();
        }

        $sql = "SELECT id_usuario, nombre_usuario, contraseña, tipo_usuario FROM usuarios WHERE nombre_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($contraseña, $row['contraseña'])) {
                $_SESSION['user_id'] = $row['id_usuario'];
                $_SESSION['username'] = $row['nombre_usuario'];
                $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
                
                // Redirección a index.php en la raíz
                header("Location: /index.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Credenciales incorrectas.";
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Credenciales incorrectas.";
            header("Location: login.php");
            exit();
        }
    }
    $conn->close();
}

    // Función que realiza el registro de nuevos usuarios
    public static function registrar()
    {
        global $conn;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre_usuario = $_POST['nombre_usuario'] ?? '';
            $contraseña = $_POST['contraseña'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $tipo_usuario = 'usuario'; // Por defecto todos son usuarios normales

            // Validaciones básicas
            if (empty($nombre_usuario)) {
                echo json_encode(['success' => false, 'message' => 'El nombre de usuario es requerido']);
                return;
            }

            if (strlen($contraseña) < 6) {
                echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
                return;
            }

            if ($contraseña !== $confirm_password) {
                echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
                return;
            }

            // Verificar si el usuario ya existe
            $check_sql = "SELECT nombre_usuario FROM usuarios WHERE nombre_usuario = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("s", $nombre_usuario);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                echo json_encode(['success' => false, 'message' => 'El nombre de usuario ya está en uso']);
                return;
            }

            // Hash de la contraseña
            $hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);

            // Insertar nuevo usuario
            $insert_sql = "INSERT INTO usuarios (nombre_usuario, contraseña, tipo_usuario) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sss", $nombre_usuario, $hashed_password, $tipo_usuario);

            if ($insert_stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Usuario registrado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario']);
            }

            $insert_stmt->close();
            $check_stmt->close();
        }

        $conn->close();
    }

    // Función para crear un administrador (opcional)
    public static function crearAdmin()
    {
        global $conn;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar si el que hace la petición es admin
            session_start();
            if ($_SESSION['tipo_usuario'] !== 'admin') {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'No autorizado']);
                return;
            }

            $nombre_usuario = $_POST['nombre_usuario'] ?? '';
            $contraseña = $_POST['contraseña'] ?? '';
            $tipo_usuario = 'admin';

            // Resto del código similar al método registrar() pero con tipo_usuario = 'admin'
            // ...
        }
    }

    // Función para cerrar sesión
    public static function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }

    // Función para verificar permisos de admin
    public static function requireAdmin()
    {
        session_start();
        if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
            header("Location: ../login.php");
            exit();
        }
    }
}