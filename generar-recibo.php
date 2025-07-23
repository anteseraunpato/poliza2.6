<?php
require_once __DIR__ . '/conexion.php';

// Obtener lista de alumnos y cuotas
$alumnos = $conn->query("SELECT * FROM alumnos ORDER BY nombre_alumno")->fetch_all(MYSQLI_ASSOC);
$cuotas = $conn->query("SELECT * FROM cuotas ORDER BY concepto")->fetch_all(MYSQLI_ASSOC);

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alumno_id'], $_POST['cuota_id'])) {
    $alumno_id = intval($_POST['alumno_id']);
    $cuota_id = intval($_POST['cuota_id']);
    
    // Validar y obtener datos con verificación de campos
    $alumno = $conn->query("SELECT * FROM alumnos WHERE id = $alumno_id")->fetch_assoc();
    $cuota = $conn->query("SELECT * FROM cuotas WHERE id = $cuota_id")->fetch_assoc();
    
    if ($alumno && $cuota) {
        // Asegurar que todos los campos necesarios existan
        $alumno = array_merge([
            'numero_control' => '',
            'nombre_alumno' => '',
            'semestre' => '00', // Valor por defecto
            'grupo' => '',
            'especialidad' => ''
        ], $alumno);
        
        $cuota = array_merge([
            'clave' => '',
            'concepto' => '',
            'cuota' => 0
        ], $cuota);
        
        // Generar número de recibo
        $recibo_numero = 'DGETAYCM-' . date('Ymd') . '-' . str_pad($alumno_id, 5, '0', STR_PAD_LEFT);
        
        // Dividir nombre del alumno de forma segura
        $nombre_parts = explode(' ', $alumno['nombre_alumno']);
        $apellido_paterno = $nombre_parts[0] ?? '';
        $apellido_materno = $nombre_parts[1] ?? '';
        $nombres = implode(' ', array_slice($nombre_parts, 2));
        
        // Mostrar vista previa
        $mostrar_vista_previa = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar Recibo de Pago</title>
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <style>
        .form-container { max-width: 800px; margin: 20px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        select, input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .btn-generar { 
            background-color: #004d3b; color: white; padding: 12px 20px; 
            border: none; border-radius: 4px; cursor: pointer; font-size: 16px; 
        }
        .vista-previa { margin-top: 30px; border: 1px solid #ddd; padding: 20px; }
        .acciones { margin-top: 20px; display: flex; gap: 10px; }
        .btn-pdf { background-color: #f44336; color: white; padding: 10px 15px; text-decoration: none; }
    </style>
</head>
<body>
    <?php include __DIR__ . '/app/views/components/navbar.php'; ?>
    
    <div class="container">
        <h1>Generar Recibo de Pago</h1>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="alumno_id">Alumno:</label>
                    <select name="alumno_id" id="alumno_id" required>
                        <option value="">-- Seleccione alumno --</option>
                        <?php foreach ($alumnos as $a): ?>
                            <option value="<?= $a['id'] ?>">
                                <?= htmlspecialchars("{$a['numero_control']} - {$a['nombre_alumno']}") ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="cuota_id">Concepto de Pago:</label>
                    <select name="cuota_id" id="cuota_id" required>
                        <option value="">-- Seleccione concepto --</option>
                        <?php foreach ($cuotas as $c): ?>
                            <option value="<?= $c['id'] ?>">
                                <?= htmlspecialchars("{$c['clave']} - {$c['concepto']} ($" . number_format($c['cuota'], 2) . ")") ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" class="btn-generar">Generar Vista Previa</button>
            </form>
            
            <?php if (isset($mostrar_vista_previa) && $mostrar_vista_previa): ?>
                <div class="vista-previa">
                    <h2>Vista Previa del Recibo</h2>
                    <p>Revise la información antes de generar el PDF.</p>
                    
                    <!-- Incrustar la plantilla del recibo -->
                    <?php include __DIR__ . '/recibo-template.php'; ?>
                    
                    <!-- Botón para generar PDF -->
                    <div class="acciones">
                        <form action="generar_pdf.php" method="POST" style="display: inline;">
                            <input type="hidden" name="alumno_id" value="<?= $alumno_id ?>">
                            <input type="hidden" name="cuota_id" value="<?= $cuota_id ?>">
                            <button type="submit" class="btn-pdf">Descargar PDF</button>
                        </form>
                        <a href="generar-recibo.php" class="button">Cancelar</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>