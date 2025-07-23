<?php require_once '../../../conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Alumnos</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background-color: #f5f5f5; }
    table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
    th { background-color: #004d3b; color: white; }
    tr:hover { background-color: #f1f1f1; }
    h2 { color: #004d3b; }
    .btn-volver {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 15px;
      background-color: #00b389;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .btn-volver:hover {
      background-color: #009f7a;
    }
    .btn-accion {
      padding: 5px 10px;
      margin: 0 2px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      color: white;
      text-decoration: none;
      display: inline-block;
    }
    .btn-editar {
      background-color: #3498db;
    }
    .btn-editar:hover {
      background-color: #2980b9;
    }
    .btn-eliminar {
      background-color: #e74c3c;
    }
    .btn-eliminar:hover {
      background-color: #c0392b;
    }
  </style>


</head>
<body>

  <h2>Lista de Alumnos Registrados</h2>

  <table>
    <thead>
      <tr>
        <th>Número de Control</th>
        <th>Nombre</th>
        <th>Semestre</th>
        <th>Grupo</th>
        <th>Especialidad</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $sql = "SELECT * FROM alumnos ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0):
          while ($row = $result->fetch_assoc()):
      ?>
        <tr>
          <td><?= htmlspecialchars($row['numero_control']) ?></td>
          <td><?= htmlspecialchars($row['nombre_alumno']) ?></td>
          <td><?= htmlspecialchars($row['semestre']) ?></td>
          <td><?= htmlspecialchars($row['grupo']) ?></td>
          <td><?= htmlspecialchars($row['especialidad']) ?></td>
          <td>
            <a href="editar-alumno.php?id=<?= $row['id'] ?>" class="btn-accion btn-editar">Editar</a>
            <a href="eliminar-alumno.php?id=<?= $row['id'] ?>" class="btn-accion btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este alumno?')">Eliminar</a>
          </td>
        </tr>
      <?php
          endwhile;
        else:
      ?>
        <tr><td colspan="6">No hay alumnos registrados.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <a href="registrar-alumno.php" class="btn-volver">Registrar nuevo alumno</a>

</body>
</html>