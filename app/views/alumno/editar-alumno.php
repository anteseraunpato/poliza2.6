<?php
require_once '../../../conexion.php';

// Obtener datos del alumno a editar
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM alumnos WHERE id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $alumno = $result->fetch_assoc();
  $stmt->close();
}

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $numero_control = $_POST['numero_control'];
  $nombre_alumno = $_POST['nombre_alumno'];
  $semestre = $_POST['semestre'];
  $grupo = $_POST['grupo'];
  $especialidad = $_POST['especialidad'];

  $sql = "UPDATE alumnos SET 
            numero_control = ?, 
            nombre_alumno = ?, 
            semestre = ?, 
            grupo = ?, 
            especialidad = ? 
            WHERE id = ?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssi", $numero_control, $nombre_alumno, $semestre, $grupo, $especialidad, $id);
  $stmt->execute();
  $stmt->close();

  header("Location: lista-alumno.php?edicion=success");
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Editar Alumno</title>
  <style>
    body {
      font-family: Arial;
      padding: 20px;
      background-color: #f5f5f5;
    }

    form {
      background: #fff;
      padding: 20px;
      border-radius: 5px;
      max-width: 500px;
      margin: auto;
    }

    input,
    select {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      background-color: #004d3b;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      border-radius: 5px;
    }

    button:hover {
      background-color: #00664f;
    }
  </style>
</head>

<body>

  <h2>Editar Alumno</h2>

  <form action="editar-alumno.php" method="POST">
    <input type="hidden" name="id" value="<?= $alumno['id'] ?>">

    <label>Número de Control:</label>
    <input type="text" name="numero_control" value="<?= htmlspecialchars($alumno['numero_control']) ?>" required>

    <label>Nombre del Alumno:</label>
    <input type="text" name="nombre_alumno" value="<?= htmlspecialchars($alumno['nombre_alumno']) ?>" required>

    <label>Semestre:</label>
    <input type="text" name="semestre" value="<?= htmlspecialchars($alumno['semestre']) ?>" required>

    <label>Grupo:</label>
    <input type="text" name="grupo" value="<?= htmlspecialchars($alumno['grupo']) ?>" required>

    <label>Especialidad:</label>
    <!-- Cambia el input de especialidad por un select -->
    <label>Especialidad:</label>
    <select name="especialidad" required>
      <option value="SAETA" <?= $alumno['especialidad'] == 'SAETA' ? 'selected' : '' ?>>SAETA</option>
      <option value="SYM" <?= $alumno['especialidad'] == 'SYM' ? 'selected' : '' ?>>SYM</option>
      <option value="AGROP" <?= $alumno['especialidad'] == 'AGROP' ? 'selected' : '' ?>>AGROP</option>
    </select>

    <button type="submit">Actualizar Alumno</button>
    <a href="lista-alumno.php" style="margin-left: 10px;">Cancelar</a>
  </form>

</body>

</html>