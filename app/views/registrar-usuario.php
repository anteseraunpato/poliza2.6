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
    <link rel="stylesheet" href="/public/assets/css/styles.css">
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

                <input type="submit" class="btn-submit" value="Registrarse">
            </form>
           
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
    </script>
</body>
</html>
