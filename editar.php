<?php
require_once 'conexion.php'; // Reemplaza la conexión local


// Obtener el ID de la póliza que se está intentando editar
$id_poliza = $_GET['id'];

// Consultar los datos del registro a editar
$sql = "SELECT fecha, total, subtotal, moneda, rfc_emisor, uuid FROM datos_xml WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_poliza);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Mostrar los datos
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Póliza</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { width: 80%; margin: auto; border: 2px solid black; padding: 10px; }
            .header, .footer { text-align: center; font-weight: bold; }
            .section { border-top: 1px solid black; padding: 10px; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; background-color: white; }
            table, th, td { border: 1px solid black; text-align: center; }
            th { background-color: #0074D9; color: white; }
            td { padding: 5px; }
            select { width: 100%; height: 30px; }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#capitulo').change(function() {
                    var id_capitulo = $(this).val();
                    $.ajax({
                        type: 'POST',
                        url: 'actualizar_partidas.php',
                        data: {id_capitulo: id_capitulo},
                        success: function(data) {
                            $('#partida').html(data);
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>EDUCACIÓN<br>SECRETARÍA DE EDUCACIÓN PÚBLICA</h2>
                <p>PÓLIZA No.: <?php echo $row['uuid']; ?></p>
            </div>
            <div class="section">
                <p>Fecha: <?php echo $row['fecha']; ?></p>
                <p><?php echo $row['rfc_emisor']; ?></p>
                <p><?php echo $row['total']; ?></p>
                <p><strong><?php echo $row['total']; ?></strong></p>
            </div>
            <div class="section">
                <h3>RECIBÍ</h3>
                <table>
                    <tr>
                        <th>PARTIDA DE GASTO</th>
                        <th>DENOMINACION</th>
                        <th>ABONO</th>
                    </tr>
                    <?php
                    if (isset($_POST['seleccionar_capitulo_partida'])) {
                        if (isset($_POST['capitulo']) && isset($_POST['partida'])) {
                            $id_capitulo = $_POST['capitulo'];
                            $id_partida = $_POST['partida'];
                            // Consultar la partida correspondiente al ID de partida seleccionado
                            $sql_partida = "SELECT partida, denominacion FROM partidas WHERE id = '$id_partida'";
                            $result_partida = $conn->query($sql_partida);
                            if ($result_partida->num_rows > 0) {
                                $row_partida = $result_partida->fetch_assoc();
                                ?>
                                <tr>
                                    <td><?php echo $row_partida['partida']; ?></td>
                                    <td><?php echo $row_partida['denominacion']; ?></td>
                                    <td><?php echo $row['total'];?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>TOTAL</strong></td>
                                    <td><strong><?php echo $row['total']; ?></strong></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo $row['total']; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>TOTAL</strong></td>
                                    <td><strong><?php echo $row['total']; ?></strong></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><?php echo $row['total']; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>TOTAL</strong></td>
                                <td><strong><?php echo $row['total']; ?></strong></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><?php echo $row['total']; ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>TOTAL</strong></td>
                            <td><strong><?php echo $row['total']; ?></strong></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="section">
                <h3>DETALLES DE LA TRANSACCIÓN</h3>
                <table>
                    <tr>
                        <th>PARTIDA</th>
                        <th>DENOMINACION</th>
                        
                    </tr>
                    <?php
                    if (isset($_POST['seleccionar_capitulo_partida'])) {
                        if (isset($_POST['capitulo']) && isset($_POST['partida'])) {
                            $id_capitulo = $_POST['capitulo'];
                            $id_partida = $_POST['partida'];
                            // Consultar la partida correspondiente al ID de partida seleccionado
                            $sql_partida = "SELECT partida, denominacion FROM partidas WHERE id = '$id_partida'";
                            $result_partida = $conn->query($sql_partida);
                            if ($result_partida->num_rows > 0) {
                                $row_partida = $result_partida->fetch_assoc();
                                ?>
                                <tr>
                                    <td><?php echo $row_partida['denominacion']; ?></td>
                                    <td><?php echo $row['subtotal']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL</strong></td>
                                    <td><strong><?php echo $row['total']; ?></strong></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $row['subtotal']; ?></td>
                                </tr>
                                <tr>
                                    <td><strong>TOTAL</strong></td>
                                    <td><strong><?php echo $row['total']; ?></strong></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td><?php echo $row['subtotal']; ?></td>
                            </tr>
                            <tr>
                                <td><strong>TOTAL</strong></td>
                                <td><strong><?php echo $row['total']; ?></strong></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td></td>
                            <td><?php echo $row['subtotal']; ?></td>
                        </tr>
                        <tr>
                            <td><strong>TOTAL</strong></td>
                            <td><strong><?php echo $row['total']; ?></strong></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="section">
                <h3>Selección de capítulo y partida</h3>
                <form action="" method="POST">  
                    <select name="capitulo" id="capitulo">
                        <?php
                        $sql_capitulos = "SELECT id, denominacion FROM capitulos";
                        $result_capitulos = $conn->query($sql_capitulos);
                        while ($row_capitulo = $result_capitulos->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row_capitulo['id']; ?>"><?php echo $row_capitulo['denominacion']; ?></option>
                        <?php } ?>
                    </select>
                    <select name="partida" id="partida">
                        <?php
                        if (isset($_POST['capitulo'])) {
                            $id_capitulo = $_POST['capitulo'];
                            $sql_partidas = "SELECT id, partida, denominacion FROM partidas WHERE id_cap = '$id_capitulo'";
                            $result_partidas = $conn->query($sql_partidas);
                            if ($result_partidas->num_rows > 0) {
                                while ($row_partida = $result_partidas->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row_partida['id']; ?>"><?php echo $row_partida['partida'] . ' - ' . $row_partida['denominacion']; ?></option>
                                <?php } ?>
                            <?php } else { ?>
                                <option value="">No hay partidas disponibles</option>
                            <?php } ?>
                        <?php } else { ?>
                            <option value="">Seleccione un capítulo</option>
                        <?php } ?>
                    </select>
                    <button type="submit" name="seleccionar_capitulo_partida">Seleccionar capítulo y partida</button>
                </form>
            </div>
            <?php
            if (isset($_POST['seleccionar_capitulo_partida'])) {
                if (isset($_POST['capitulo']) && isset($_POST['partida'])) {
                    $id_capitulo = $_POST['capitulo'];
                    $id_partida = $_POST['partida'];
                    // Realizar la acción correspondiente con la selección del capítulo y la partida
                    echo "Capítulo seleccionado: $id_capitulo, Partida seleccionada: $id_partida";
                }
            }
            ?>
            <div class="section">
                <p><strong>OBSERVACIONES:</strong></p>
                <form action="guardar_poliza.php" method="POST">
                    <input type="hidden" name="uuid" value="<?php echo $row['uuid']; ?>">
                    <input type="hidden" name="rfc_emisor" value="<?php echo $row['rfc_emisor']; ?>">
                    <input type="hidden" name="total" value="<?php echo $row['total']; ?>">
                    <?php if (isset($_POST['capitulo']) && isset($_POST['partida'])) { ?>
                        <?php
                        $id_capitulo = $_POST['capitulo'];
                        $id_partida = $_POST['partida'];

                        // Consultar la partida correspondiente al ID de partida seleccionado
                        $sql_partida = "SELECT partida, denominacion FROM partidas WHERE id = '$id_partida'";
                        $result_partida = $conn->query($sql_partida);
                        if ($result_partida->num_rows > 0) {
                            $row_partida = $result_partida->fetch_assoc();
                            $partida_denominacion = $row_partida['denominacion'];
                            $partida_codigo = $row_partida['partida'];
                        } else {
                            $partida_denominacion = '';
                            $partida_codigo = '';
                        }

                        // Consultar el capítulo correspondiente al ID de capítulo seleccionado
                        $sql_capitulo = "SELECT denominacion FROM capitulos WHERE id = '$id_capitulo'";
                        $result_capitulo = $conn->query($sql_capitulo);
                        if ($result_capitulo->num_rows > 0) {
                            $row_capitulo = $result_capitulo->fetch_assoc();
                            $capitulo_denominacion = $row_capitulo['denominacion'];
                        } else {
                            $capitulo_denominacion = '';
                        }
                        ?>
                        <input type="hidden" name="capitulo" value="<?php echo $capitulo_denominacion; ?>">
                        <input type="hidden" name="partida" value="<?php echo $partida_denominacion; ?>">
                    <?php } ?>
                     <textarea name="observacion" placeholder="Ingrese la observación"></textarea>
<input type="text" name="elaborador" placeholder="ELABORADO POR:" style="height: 30px; width: 200px;">
<input type="text" name="creador" placeholder="AUTORIZADO POR:" style="height: 30px; width: 200px;">
<input type="text" name="verificador" placeholder="REGISTRO EN EL LIBRO" style="height: 30px; width: 200px;">
                    <button type="submit" name="guardar_poliza">Guardar Póliza</button>
                </form>
                <form action="generar_pdf.php" method="POST" target="_blank">
                    <input type="hidden" name="uuid" value="<?php echo $row['uuid']; ?>">
                    <input type="hidden" name="rfc_emisor" value="<?php echo $row['rfc_emisor']; ?>">
                    <input type="hidden" name="total" value="<?php echo $row['total']; ?>">
                    <?php if (isset($_POST['capitulo']) && isset($_POST['partida'])) { ?>
                        <?php
                        $id_capitulo = $_POST['capitulo'];
                        $id_partida = $_POST['partida'];

                        // Consultar la partida correspondiente al ID de partida seleccionado
                        $sql_partida = "SELECT partida, denominacion FROM partidas WHERE id = '$id_partida'";
                        $result_partida = $conn->query($sql_partida);
                        if ($result_partida->num_rows > 0) {
                            $row_partida = $result_partida->fetch_assoc();
                            $partida_denominacion = $row_partida['denominacion'];
                            $partida_codigo = $row_partida['partida'];
                        } else {
                            $partida_denominacion = '';
                            $partida_codigo = '';
                        }

                        // Consultar el capítulo correspondiente al ID de capítulo seleccionado
                        $sql_capitulo = "SELECT denominacion FROM capitulos WHERE id = '$id_capitulo'";
                        $result_capitulo = $conn->query($sql_capitulo);
                        if ($result_capitulo->num_rows > 0) {
                            $row_capitulo = $result_capitulo->fetch_assoc();
                            $capitulo_denominacion = $row_capitulo['denominacion'];
                        } else {
                            $capitulo_denominacion = '';
                        }
                        ?>
                        <input type="hidden" name="capitulo" value="<?php echo $capitulo_denominacion; ?>">
                        <input type="hidden" name="partida" value="<?php echo $partida_denominacion; ?>">
                        <input type="hidden" name="partida_codigo" value="<?php echo $partida_codigo; ?>">
                    <?php } ?>
                    <textarea name="observacion" placeholder="Ingrese la observación"></textarea>
<input type="text" name="elaborador" placeholder="ELABORADO POR:" style="height: 30px; width: 200px;">
<input type="text" name="creador" placeholder="AUTORIZADO POR:" style="height: 30px; width: 200px;">
<input type="text" name="verificador" placeholder="REGISTRO EN EL LIBRO" style="height: 30px; width: 200px;">
                    <button type="submit" name="generar_pdf" class="button third-color" >Generar PDF</button>
                </form>
            </div>
            <div class="section">
                <button type="button" onclick="window.location.href='registro.php';">Cancelar Póliza</button>
            </div>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "No se encontraron registros.";
}

$conn->close();
?>