<?php
session_start();
$error_message = $_SESSION['error_message'] ?? '';
$success_message = $_SESSION['success_message'] ?? '';
unset($_SESSION['error_message'], $_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
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
            border-radius: 4px;
            box-sizing: border-box;
        }

        .textbox input:focus {
            border-color: #007bff;
            outline: none;
        }

        .error, .success {
            padding: 20px;
            text-align: center;
            margin-top: 20px;
            border-radius: 5px;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .btn-accept {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-accept:hover {
            background-color: #0056b3;
        }

        .back-link {
            margin-top: 10px;
            text-align: center;
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
        <h2>Cambiar Contraseña</h2>

        <!-- Mostrar mensaje de éxito si la contraseña fue cambiada correctamente -->
        <?php if (!empty($success_message)) { ?>
            <div class="success">
                <?php echo $success_message; ?>
                <br>
                <a href="login.php" class="btn-accept">Aceptar</a>
            </div>
        <?php } ?>

        <!-- Mostrar mensaje de error -->
        <?php if (!empty($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        
        <!-- Formulario de cambio de contraseña -->
        <?php if (empty($success_message)) { ?>
            <form action="cambio_password_action.php" method="POST">
                <div class="textbox">
                    <input type="text" placeholder="Nombre de Usuario" name="username" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Contraseña Actual" name="current_password" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Nueva Contraseña" name="new_password" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Confirmar Nueva Contraseña" name="confirm_password" required>
                </div>

                <div class="textbox">
                    <input type="text" placeholder="Respuesta de Seguridad" name="security_answer" required>
                </div>

                <input type="submit" value="Cambiar Contraseña">
            </form>
        <?php } ?>
    </div>
</body>
</html>


