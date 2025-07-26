<?php
$servername = "localhost";
$username = "root";
$password = "17082009";
$dbname = "poliza";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>