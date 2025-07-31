<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

try {
    // Validar datos de entrada
    if (!isset($_POST['alumno_id'], $_POST['cuota_id'])) {
        throw new Exception("Datos incompletos");
    }

    $alumno_id = intval($_POST['alumno_id']);
    $cuota_id = intval($_POST['cuota_id']);

    // Obtener datos
    $alumno = $conn->query("SELECT * FROM alumnos WHERE id = $alumno_id")->fetch_assoc();
    $cuota = $conn->query("SELECT * FROM cuotas WHERE id = $cuota_id")->fetch_assoc();

    if (!$alumno || !$cuota) {
        throw new Exception("Registro no encontrado");
    }

    // Asignar valores por defecto si faltan campos
    $alumno = array_merge([
        'numero_control' => '',
        'nombre_alumno' => 'N/A',
        'semestre' => '00',
        'grupo' => '',
        'especialidad' => ''
    ], $alumno);

    $cuota = array_merge([
        'clave' => '',
        'concepto' => 'N/A',
        'cuota' => 0
    ], $cuota);

    // Datos para el recibo
    $recibo_numero = 'DGETAYCM-' . date('Ymd') . '-' . str_pad($alumno_id, 5, '0', STR_PAD_LEFT);
    $nombre_parts = explode(' ', $alumno['nombre_alumno']);
    $apellido_paterno = $nombre_parts[0] ?? '';
    $apellido_materno = $nombre_parts[1] ?? '';
    $nombres = implode(' ', array_slice($nombre_parts, 2));

    // Iniciar mPDF
    $mpdf = new Mpdf([
        'format' => 'Letter',
        'margin_left' => 5,
        'margin_right' => 5,
        'margin_top' => 5,
        'margin_bottom' => 5
    ]);

    ob_start();
    include __DIR__ . '/recibo-template.php'; // este archivo debe generar HTML puro
    $html = ob_get_clean();

    $mpdf->WriteHTML($html);

    // Nombre del archivo PDF
    $filename = 'Recibo_' . preg_replace('/[^a-z0-9]/i', '_', $alumno['numero_control']) . '_' . date('Ymd') . '.pdf';

    // Descargar el PDF
    $mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);

} catch (Exception $e) {
    die("Error al generar PDF: " . $e->getMessage());
}
