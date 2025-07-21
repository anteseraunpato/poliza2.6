<?php
require_once 'conexion.php'; // Reemplaza la conexión local


$pregunta_seguridad = "";
$error_message = "";

// Verificar si el nombre de usuario fue enviado
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $nombre_usuario = $_POST['username'];

    // Usar consulta preparada para evitar inyección SQL
    $sql = "SELECT pregunta_seguridad FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    // Vinculamos el parámetro (el nombre de usuario) y lo ejecutamos
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Si el usuario existe, obtener la pregunta de seguridad
        $stmt->bind_result($pregunta_seguridad);
        $stmt->fetch();
    } else {
        // Si el usuario no se encuentra
        $error_message = "Usuario no encontrado.";
    }

    $stmt->close();
} else {
    $error_message = "Por favor, ingresa un nombre de usuario.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .change-password-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .textbox {
            margin-bottom: 15px;
        }

        .textbox input {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .textbox input:focus {
            border-color: #007bff;
            outline: none;
        }

        .error {
            color: #721c24;
            background-color: #f8d7da;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="change-password-box">
            <h2>Cambiar Contraseña</h2>

            <!-- Mostrar mensaje de error si el usuario no existe -->
            <?php if (!empty($error_message)) { ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php } ?>

            <!-- Si la pregunta de seguridad existe, mostrarla -->
            <?php if (!empty($pregunta_seguridad)) { ?>
                <form action="cambiocontroller.php" method="POST">
                    <div class="textbox">
                        <input type="text" placeholder="Pregunta de Seguridad" name="security_question" value="<?php echo $pregunta_seguridad; ?>" readonly>
                    </div>
                    <div class="textbox">
                        <input type="text" placeholder="Respuesta de Seguridad" name="security_answer" required>
                    </div>
                    <div class="textbox">
                        <input type="password" placeholder="Nueva Contraseña" name="new_password" required>
                    </div>
                    <div class="textbox">
                        <input type="password" placeholder="Confirmar Nueva Contraseña" name="confirm_password" required>
                    </div>
                    <input type="hidden" name="username" value="<?php echo $nombre_usuario; ?>"> <!-- Enviamos el nombre de usuario oculto -->
                    <input type="submit" value="Cambiar Contraseña">
                </form>
            <?php } ?>
        </div>
    </div>

</body>
</html>
