<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // Redirigir al login si no hay sesión activa
    header("Location: /app/views/login.php");
    exit();
}
