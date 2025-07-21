<?php
namespace App\Controllers;

require_once __DIR__ . '/../conexion.php';

class AuthController
{
    //Función que realiza el Login
    public static function login()
    {
        session_start();
        global $conn;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre_usuario = $_POST['username'] ?? '';
            $contraseña = $_POST['password'] ?? '';

            if (!$nombre_usuario || !$contraseña) {
                $_SESSION['error_message'] = "Por favor llena todos los campos.";
                header("Location: login.php");
                exit();
            }

            $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $nombre_usuario);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if (password_verify($contraseña, $row['contraseña'])) {
                    $_SESSION['username'] = $nombre_usuario;
                    header("Location: registro.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = "Contraseña incorrecta.";
                    header("Location: login.php");
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "El nombre de usuario no existe.";
                header("Location: login.php");
                exit();
            }
        }

        $conn->close();
    }

    //Función que realiza el registro de nuevos usuarios
    public static function registrar()
{
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_completo = $_POST['nombre_completo'] ?? '';
        $nombre_usuario = $_POST['nombre_usuario'] ?? '';
        $correo_electronico = $_POST['correo_electronico'] ?? '';
        $edad = $_POST['edad'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
        $localidad = $_POST['localidad'] ?? '';
        $genero = $_POST['genero'] ?? '';
        $contraseña = $_POST['contraseña'] ?? '';
        $confirmar_contraseña = $_POST['confirm_password'] ?? '';
        $pregunta_seguridad = $_POST['pregunta_seguridad'] ?? '';
        $respuesta_seguridad = $_POST['respuesta_seguridad'] ?? '';

        if ($contraseña !== $confirmar_contraseña) {
            echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
            return;
        }

        $contraseña_cifrada = password_hash($contraseña, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios 
            (nombre_completo, nombre_usuario, correo_electronico, edad, telefono, fecha_nacimiento, localidad, genero, contraseña, pregunta_seguridad, respuesta_seguridad)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param(
                "sssssssssss",
                $nombre_completo,
                $nombre_usuario,
                $correo_electronico,
                $edad,
                $telefono,
                $fecha_nacimiento,
                $localidad,
                $genero,
                $contraseña_cifrada,
                $pregunta_seguridad,
                $respuesta_seguridad
            );

            if ($stmt->execute()) {
                echo "<script>alert('Cuenta creada exitosamente.'); window.location.href = 'login.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error al registrar el usuario.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Error al preparar la consulta.'); window.history.back();</script>";
        }

        $conn->close();
    }
}

    //Función para el cambio de contraseña
    public static function cambiarPassword()
{
    global $conn;
    session_start();

    $error_message = "";
    $success_message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_usuario = $_POST['username'] ?? '';
        $respuesta_seguridad = $_POST['security_answer'] ?? '';
        $nueva_contrasena = $_POST['new_password'] ?? '';
        $confirmar_contrasena = $_POST['confirm_password'] ?? '';

        if ($nueva_contrasena !== $confirmar_contrasena) {
            $_SESSION['error_message'] = "Las contraseñas no coinciden.";
            header("Location: cambio_password.php");
            exit();
        }

        $sql = "SELECT respuesta_seguridad FROM usuarios WHERE nombre_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($respuesta_correcta);
            $stmt->fetch();

            if ($respuesta_seguridad === $respuesta_correcta) {
                $nueva_contrasena_encriptada = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

                $update_sql = "UPDATE usuarios SET contraseña = ? WHERE nombre_usuario = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ss", $nueva_contrasena_encriptada, $nombre_usuario);

                if ($update_stmt->execute()) {
                    $_SESSION['success_message'] = "Contraseña actualizada correctamente.";
                    header("Location: cambio_password.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = "Error al actualizar la contraseña.";
                    header("Location: cambio_password.php");
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "Respuesta de seguridad incorrecta.";
                header("Location: cambio_password.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Usuario no encontrado.";
            header("Location: cambio_password.php");
            exit();
        }
    }

    $conn->close();
}

}
