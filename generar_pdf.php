<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/libs/html2pdf/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;

try {
    // Validar datos de entrada
    if (!isset($_POST['alumno_id'], $_POST['cuota_id'])) {
        throw new Exception("Datos incompletos");
    }

    $alumno_id = intval($_POST['alumno_id']);
    $cuota_id = intval($_POST['cuota_id']);

    // Obtener datos con verificaciones
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

    // Procesar datos para el PDF
    $recibo_numero = 'DGETAYCM-' . date('Ymd') . '-' . str_pad($alumno_id, 5, '0', STR_PAD_LEFT);
    $nombre_parts = explode(' ', $alumno['nombre_alumno']);
    $apellido_paterno = $nombre_parts[0] ?? '';
    $apellido_materno = $nombre_parts[1] ?? '';
    $nombres = implode(' ', array_slice($nombre_parts, 2));

    // Generar PDF
    $html2pdf = new Html2Pdf('P', 'Letter', 'es', true, 'UTF-8', [10, 10, 10, 10]);
    $html2pdf->setDefaultFont('Arial');
    
    ob_start();
    include __DIR__ . '/recibo-template.php';
    $html = ob_get_clean();
    
    $html2pdf->writeHTML($html);
    
    // Nombre del archivo PDF
    $filename = 'Recibo_' . preg_replace('/[^a-z0-9]/i', '_', $alumno['numero_control']) . '_' . date('Ymd') . '.pdf';
    
    // Descargar PDF
    $html2pdf->output($filename, 'D');

} catch (Exception $e) {
    die("Error al generar PDF: " . $e->getMessage());
}