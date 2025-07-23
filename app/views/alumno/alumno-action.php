<?php
require_once '../../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_control = $_POST['numero_control'];
    $nombre_alumno = $_POST['nombre_alumno'];
    $semestre = $_POST['semestre'];
    $grupo = $_POST['grupo'];
    $especialidad = $_POST['especialidad'];

    $sql = "INSERT INTO alumnos (numero_control, nombre_alumno, semestre, grupo, especialidad) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $numero_control, $nombre_alumno, $semestre, $grupo, $especialidad);
    
    if($stmt->execute()) {
        header("Location: ../alumno/lista-alumno.php?registro=success");
    } else {
        header("Location: ../alumno/registrar-alumno.php?registro=error");
    }
    
    $stmt->close();
    $conn->close();
    exit;
}
?>