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
  <link rel="stylesheet" href="/public/assets/css/styles.css">
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
    <select name="semestre" required>
      <option value="1" <?= $alumno['semestre'] == '1' ? 'selected' : '' ?>>1</option>
      <option value="2" <?= $alumno['semestre'] == '2' ? 'selected' : '' ?>>2</option>
      <option value="3" <?= $alumno['semestre'] == '3' ? 'selected' : '' ?>>3</option>
      <option value="4" <?= $alumno['semestre'] == '4' ? 'selected' : '' ?>>4</option>
      <option value="5" <?= $alumno['semestre'] == '5' ? 'selected' : '' ?>>5</option>
      <option value="6" <?= $alumno['semestre'] == '6' ? 'selected' : '' ?>>6</option>
    </select>

    <label>Grupo:</label>
    <select name="grupo" required>
      <option value="A" <?= $alumno['grupo'] == 'A' ? 'selected' : '' ?>>A</option>
      <option value="B" <?= $alumno['grupo'] == 'B' ? 'selected' : '' ?>>B</option>
      <option value="C" <?= $alumno['grupo'] == 'C' ? 'selected' : '' ?>>C</option>
      <option value="D" <?= $alumno['grupo'] == 'D' ? 'selected' : '' ?>>D</option>
    </select>

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