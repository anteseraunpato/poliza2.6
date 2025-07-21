<?php
require_once 'conexion.php'; // Reemplaza la conexión local

// Obtener el UUID del registro a eliminar
$uuid = $_GET['uuid'];

// Obtener el ID del capítulo seleccionado
$id_capitulo = $_POST['id_capitulo'];

// Consultar las partidas relacionadas con el capítulo seleccionado
$sql_partidas = "SELECT id, partida, denominacion FROM partidas WHERE id_cap = '$id_capitulo'";
$result_partidas = $conn->query($sql_partidas);

// Mostrar las partidas
while ($row_partida = $result_partidas->fetch_assoc()) {
    ?>
    <option value="<?php echo $row_partida['id']; ?>"><?php echo $row_partida['partida'] . ' - ' . $row_partida['denominacion']; ?></option>
<?php } ?>

<?php
$conn->close();
?>