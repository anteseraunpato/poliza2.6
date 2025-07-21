<?php
include __DIR__ . '/../../conexion.php'; // Ajusta la ruta si es necesario

// Consulta para obtener todos los alumnos ordenados por número de control o nombre
$sql = "SELECT numero_control, nombre_alumno, semestre, grupo, especialidad FROM alumnos ORDER BY numero_control";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Alumnos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { margin-bottom: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>

<h1>Lista de Alumnos</h1>

<table>
    <thead>
        <tr>
            <th>Número de Control</th>
            <th>Nombre</th>
            <th>Semestre</th>
            <th>Grupo</th>
            <th>Especialidad</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($alumno = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($alumno['numero_control']) ?></td>
                    <td><?= htmlspecialchars($alumno['nombre_alumno']) ?></td>
                    <td><?= htmlspecialchars($alumno['semestre']) ?></td>
                    <td><?= htmlspecialchars($alumno['grupo']) ?></td>
                    <td><?= htmlspecialchars($alumno['especialidad'] ?? '') ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No hay alumnos registrados.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
