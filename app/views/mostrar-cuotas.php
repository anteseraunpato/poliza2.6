<?php
include __DIR__ . '/../../conexion.php';

// Paso 1: obtener los grupos (A1, B1)
$sql_grupos = "SELECT DISTINCT identificador FROM cuotas WHERE identificador IN ('A1', 'B1') ORDER BY identificador";
$result_grupos = $conn->query($sql_grupos);

$datos = [];

while ($grupo = $result_grupos->fetch_assoc()) {
    $grupo_id = $grupo['identificador'];

    // Paso 2: obtener subgrupos relacionados (A2 para A1, B2 para B1)
    // Asumimos que subgrupo es el mismo identificador pero con "2" en vez de "1"
    $subgrupo_id = substr($grupo_id, 0, 1) . '2'; // Ejemplo: 'A1' -> 'A2'

    $sql_subgrupos = "SELECT DISTINCT identificador FROM cuotas WHERE identificador = '$subgrupo_id'";
    $result_subgrupos = $conn->query($sql_subgrupos);

    $subgrupos = [];

    // Paso 3: para cada subgrupo, obtener cuotas
    while ($subgrupo = $result_subgrupos->fetch_assoc()) {
        $id_subgrupo = $subgrupo['identificador'];

        $sql_cuotas_sub = "SELECT clave, concepto, cuota FROM cuotas WHERE identificador = '$id_subgrupo' ORDER BY clave";
        $res_cuotas_sub = $conn->query($sql_cuotas_sub);

        $cuotas_sub = [];
        while ($cuota = $res_cuotas_sub->fetch_assoc()) {
            $cuotas_sub[] = $cuota;
        }

        $subgrupos[$id_subgrupo] = $cuotas_sub;
    }

    // Paso 4: obtener cuotas directas del grupo (A1 o B1)
    $sql_cuotas_grupo = "SELECT clave, concepto, cuota FROM cuotas WHERE identificador = '$grupo_id' ORDER BY clave";
    $res_cuotas_grupo = $conn->query($sql_cuotas_grupo);

    $cuotas_grupo = [];
    while ($cuota = $res_cuotas_grupo->fetch_assoc()) {
        $cuotas_grupo[] = $cuota;
    }

    // Guardamos todo
    $datos[$grupo_id] = [
        'cuotas' => $cuotas_grupo,
        'subgrupos' => $subgrupos,
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Cuotas por Grupo y Subgrupo</title>

    <link rel="stylesheet" href="/public/assets/css/styles.css">
</head>
<body>
    <h1>Cuotas organizadas por Grupo y Subgrupo</h1>

    <?php foreach ($datos as $grupo_id => $info): ?>
        <h2>Grupo <?= htmlspecialchars($grupo_id) ?></h2>

        <?php if (!empty($info['cuotas'])): ?>
            <table>
                <thead>
                    <tr><th>Clave</th><th>Concepto</th><th>Cuota</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($info['cuotas'] as $cuota): ?>
                        <tr>
                            <td><?= htmlspecialchars($cuota['clave']) ?></td>
                            <td><?= htmlspecialchars($cuota['concepto']) ?></td>
                            <td>$<?= number_format($cuota['cuota'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <?php foreach ($info['subgrupos'] as $sub_id => $cuotas_sub): ?>
            <h3>Subgrupo <?= htmlspecialchars($sub_id) ?></h3>
            <table>
                <thead>
                    <tr><th>Clave</th><th>Concepto</th><th>Cuota</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($cuotas_sub as $cuota): ?>
                        <tr>
                            <td><?= htmlspecialchars($cuota['clave']) ?></td>
                            <td><?= htmlspecialchars($cuota['concepto']) ?></td>
                            <td>$<?= number_format($cuota['cuota'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>

    <?php endforeach; ?>
</body>
</html>
