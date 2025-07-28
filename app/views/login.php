<?php
require_once __DIR__ . '/../../config.php'; // o ajustar según ubicación
require_once BASE_PATH . '/app/middleware/guest.php'; // <-- Verifica que no haya sesión activa
require_once __DIR__ . '/../controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    App\Controllers\AuthController::login();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/public/assets/css/styles.css">
<link rel="stylesheet" href="/public/assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Iniciar Sesión</h2>
            <form action="login.php" method="POST"> <!-- Cambiado a login.php -->
                <div class="textbox">
                    <input type="text" placeholder="Nombre de Usuario" name="username" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Contraseña" name="password" required>
                </div>
                <input type="submit" value="Iniciar Sesión">
            </form>
            
            <?php if (isset($_SESSION['error_message'])) { ?>
                <div class="error"><?php echo htmlspecialchars($_SESSION['error_message']); ?></div>
                <?php unset($_SESSION['error_message']); ?>
            <?php } ?>
        </div>
    </div>
</body>
</html>