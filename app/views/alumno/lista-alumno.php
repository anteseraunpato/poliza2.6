<?php require_once '../../../conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Lista de Alumnos</title>
  <link rel="stylesheet" href="/public/assets/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="/public/assets/css/styles.css">
</head>
<body>

  <header class="header">
    <div class="header-center">
      <h1>GENERADOR DE PÓLIZAS</h1>
    </div>
    <?php include __DIR__ . '/../../views/components/navbar.php'; ?>
  </header>

  <h2 style="text-align: center;">Lista de Alumnos Registrados</h2>

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
