<?php
require_once 'conexion.php'; // Reemplaza la conexión local


// Obtener el ID del capítulo seleccionado
$idCapitulo = $_GET['idCapitulo'];

// Consultar las partidas correspondientes al capítulo seleccionado
$sql = "SELECT id, descripcion FROM partidas WHERE id_cap = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCapitulo);
$stmt->execute();
$result = $stmt->get_result();

// Convertir el resultado a un arreglo JSON
$partidas = array();
while ($row = $result->fetch_assoc()) {
    $partidas[] = $row;
}

// Imprimir el arreglo JSON
echo json_encode($partidas);

$conn->close();
?>