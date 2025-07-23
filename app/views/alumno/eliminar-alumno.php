<?php
require_once '../../../conexion.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Preparar la consulta de eliminación
    $sql = "DELETE FROM alumnos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        header("Location: lista-alumno.php?eliminacion=success");
    } else {
        header("Location: lista-alumno.php?eliminacion=error");
    }
    
    $stmt->close();
    $conn->close();
    exit;
} else {
    header("Location: lista-alumno.php");
    exit;
}
?>