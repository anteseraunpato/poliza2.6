<?php
require_once 'conexion.php'; // Reemplaza la conexión local

// Obtener el UUID del registro a eliminar
$uuid = $_GET['uuid'];

// Consulta SQL para eliminar el registro
$sql = "DELETE FROM datos_xml WHERE uuid = '$uuid'";

// Ejecutar consulta
if ($conn->query($sql) === TRUE) {
    // Redireccionar a la página de vista.php con un parámetro GET
    header("Location: vista.php?message=Registro eliminado correctamente");
} else {
    echo "Error al eliminar el registro: " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>