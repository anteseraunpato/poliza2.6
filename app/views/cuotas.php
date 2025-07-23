<?php
require_once __DIR__ . '/../../conexion.php';

session_start(); // Para manejar mensajes de feedback

// Procesar eliminación
if (isset($_GET['eliminar'])) {
    $id_eliminar = intval($_GET['eliminar']);
    
    $stmt = $conn->prepare("DELETE FROM cuotas WHERE id = ?");
    $stmt->bind_param("i", $id_eliminar);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Cuota eliminada correctamente.";
    } else {
        $_SESSION['error'] = "Error al eliminar la cuota.";
    }
    
    header("Location: cuotas.php");
    exit();
}

// Procesar edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $clave = htmlspecialchars($_POST['clave']);
    $concepto = htmlspecialchars($_POST['concepto']);
    $cuota = floatval($_POST['cuota']);
    $identificador = htmlspecialchars($_POST['identificador']);

    $stmt = $conn->prepare("UPDATE cuotas SET clave=?, concepto=?, cuota=?, identificador=? WHERE id=?");
    $stmt->bind_param("ssdsi", $clave, $concepto, $cuota, $identificador, $id);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Cuota actualizada correctamente.";
    } else {
        $_SESSION['error'] = "Error al actualizar la cuota.";
    }
    
    header("Location: cuotas.php");
    exit();
}

// Obtener todas las cuotas
$result = $conn->query("SELECT * FROM cuotas ORDER BY id DESC");

// Mostrar mensajes de feedback
$mensaje = $_SESSION['mensaje'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['mensaje'], $_SESSION['error']);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Cuotas</title>
<link rel="stylesheet" href="/public/assets/css/styles.css">
</head>
<body>

<h2>Lista de Cuotas</h2>

<?php if ($mensaje): ?>
    <div class="alert success"><?= $mensaje ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert error"><?= $error ?></div>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Clave</th>
        <th>Concepto</th>
        <th>Cuota</th>
        <th>Identificador</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['clave']) ?></td>
            <td><?= htmlspecialchars($row['concepto']) ?></td>
            <td>$<?= number_format($row['cuota'], 2) ?></td>
            <td><?= htmlspecialchars($row['identificador']) ?></td>
            <td>
                <a class="button" href="?editar=<?= $row['id'] ?>">Editar</a>
                <a class="button delete" href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta cuota?')">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<?php if (isset($_GET['editar'])): 
    $editar_id = intval($_GET['editar']);
    $stmt = $conn->prepare("SELECT * FROM cuotas WHERE id=?");
    $stmt->bind_param("i", $editar_id);
    $stmt->execute();
    $cuota = $stmt->get_result()->fetch_assoc();
    
    if ($cuota): ?>
        <div class="form-edit">
            <h3>Editar Cuota</h3>
            <form method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($cuota['id']) ?>">
                <label>Clave:</label>
                <input type="text" name="clave" value="<?= htmlspecialchars($cuota['clave']) ?>" required>
                <label>Concepto:</label>
                <input type="text" name="concepto" value="<?= htmlspecialchars($cuota['concepto']) ?>" required>
                <label>Cuota:</label>
                <input type="number" step="0.01" name="cuota" value="<?= htmlspecialchars($cuota['cuota']) ?>" required>
                <label>Identificador:</label>
                <input type="text" name="identificador" value="<?= htmlspecialchars($cuota['identificador']) ?>" required>
                <input type="submit" value="Guardar Cambios">
                <a href="cuotas.php" style="display: inline-block; margin-top: 10px;">Cancelar</a>
            </form>
        </div>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>