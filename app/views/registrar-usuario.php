<?php
require_once __DIR__ . '/../controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    App\Controllers\AuthController::registrar();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cuenta</title>
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <style>
        /* Estilos para el formulario */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }
        .register-box {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 30px;
        }
        .register-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .textbox {
            margin-bottom: 20px;
        }
        .textbox input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .textbox input:focus {
            border-color: #3498db;
            outline: none;
        }
        .terms {
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        .terms input {
            margin-right: 10px;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-submit:hover {
            background-color: #2980b9;
        }
        .options {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .options a {
            color: #3498db;
            text-decoration: none;
        }
        .options a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body> 
    <div class="container">
        <div class="register-box">
            <h2>Crear Cuenta</h2>
            
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="error-message"><?= htmlspecialchars($_SESSION['error_message']) ?></div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            
            <form action="registrar-usuario.php" method="POST" id="registerForm">
                <div class="textbox">
                    <input type="text" placeholder="Nombre de Usuario" name="nombre_usuario" required minlength="4" maxlength="50">
                </div>

                <div class="textbox">
                    <input type="password" placeholder="Contraseña" name="contraseña" required minlength="6" id="password">
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Confirmar Contraseña" name="confirm_password" required minlength="6" id="confirm_password">
                </div>

                <div class="textbox terms">
                    <label>
                        <input type="checkbox" name="terms" required>
                        Acepto los <a href="#" target="_blank">términos y condiciones</a>
                    </label>
                </div>

                <input type="submit" class="btn-submit" value="Registrarse">
            </form>
            <div class="options">
                ¿Ya tienes cuenta? <a href="login.php">Iniciar Sesión</a>
            </div>
        </div>
    </div>

    <script>
        // Validación de contraseñas coincidentes
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }
            return true;
        });

        // Mostrar/ocultar contraseña (opcional)
        // Puedes añadir iconos de ojo para mostrar/ocultar contraseña si lo deseas
    </script>
</body>
</html>