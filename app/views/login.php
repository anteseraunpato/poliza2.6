<?php
// Iniciar la sesión para obtener el mensaje de error si existe
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>  
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #f4f7fc;  
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #e4e9f2;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100%;
            height: 100%;
            padding: 20px;
        }

        .login-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .login-box:hover {
            transform: scale(1.05);
            box-shadow: 0 25px 40px rgba(0, 0, 0, 0.15); 
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #4A4A4A;
        }

        .textbox {
            margin-bottom: 20px;
            position: relative;
        }

        .textbox input {
            width: 100%;
            padding: 14px 20px;
            border-radius: 8px;
            border: 2px solid #d1d9e6;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #4A4A4A;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .textbox input:focus {
            border-color: #5c7cfa;
            outline: none;
            background-color: #f3f6fc;
            box-shadow: 0 0 8px rgba(92, 124, 250, 0.3); 
        }

        input[type="submit"] {
            width: 100%;
            padding: 16px;
            background-color: #5c7cfa;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #4a68d8;
            transform: translateY(-2px); 
        }

        .options {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }

        .options a {
            text-decoration: none;
            color: #5c7cfa;
            font-weight: bold;
        }

        .options a:hover {
            color: #4a68d8;
        }

        .options a:active {
            color: #3e58b0;
        }

        .container {
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <form action="logincontroller.php" method="POST">
                <div class="textbox">
                    <input type="text" placeholder="Nombre de Usuario" name="username" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Contraseña" name="password" required>
                </div>
                <input type="submit" value="Iniciar Sesión">
            </form>
            
            <!-- Mostrar el mensaje de error en caso de que haya uno -->
            <?php if (isset($_SESSION['error_message'])) { ?>
                <div class="error"><?php echo $_SESSION['error_message']; ?></div>
                <?php unset($_SESSION['error_message']); ?> <!-- Limpiar el mensaje después de mostrarlo -->
            <?php } ?>
            
            <div class="options">
                <a href="registro.php">Crear Cuenta</a> | 
                <a href="cambio_contraseña.php">Olvidaste tu Contraseña?</a>
            </div>
        </div>
    </div>
</body>
</html>
