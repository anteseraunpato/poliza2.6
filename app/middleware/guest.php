<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    // Si ya está logueado, redirigir al inicio
    header("Location: /index.php");
    exit();
}
