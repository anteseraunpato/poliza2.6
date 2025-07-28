<?php
$servername = "localhost";
$username = "root";
$password = "tu_password";
$dbname = "facturas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>