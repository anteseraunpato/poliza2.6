<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/conexion.php';

// Función para convertir número a letras en pesos mexicanos
function numeroALetras($numero) {
    $formatter = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
    $entero = floor($numero);
    $centavos = round(($numero - $entero) * 100);
    $letras = strtoupper($formatter->format($entero));
    return "$letras PESOS " . str_pad($centavos, 2, '0', STR_PAD_LEFT) . "/100 M.N.";
}

// Verifica parámetros requeridos
if (!isset($_POST['alumno_id'], $_POST['cuota_id'])) {
    die('Datos incompletos.');
}

$alumno_id = intval($_POST['alumno_id']);
$cuota_id = intval($_POST['cuota_id']);

// Consultas de base de datos
$alumno = $conn->query("SELECT * FROM alumnos WHERE id = $alumno_id")->fetch_assoc();
$cuota = $conn->query("SELECT * FROM cuotas WHERE id = $cuota_id")->fetch_assoc();
if (!$alumno || !$cuota) die('Datos no encontrados.');

// Genera número de recibo
$res = $conn->query("SELECT MAX(id) AS ultimo FROM recibos")->fetch_assoc();
$numero_siguiente = str_pad(($res['ultimo'] ?? 0) + 1, 5, '0', STR_PAD_LEFT);
$numero_recibo = "DGETAYCM $numero_siguiente";

// Fecha actual
$fecha_actual = date('d-M-y');
$total = $cuota['cuota'];
$total_letras = numeroALetras($total);

// Divide nombre completo (opcional si no está separado en DB)
$partes = explode(" ", $alumno['nombre_alumno']);
$apellido_paterno = strtoupper($partes[0] ?? '');
$apellido_materno = strtoupper($partes[1] ?? '');
$nombres = strtoupper(implode(" ", array_slice($partes, 2)));

// HTML para mPDF
$html = '
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            height: 396pt;
            padding: 5px;
            box-sizing: border-box;
            border: 1px solid black;
        }

        .header, .recipient-section, .address, .amount-section, .table-section, .signature-section, .note {
            margin-bottom: 5px;
        }

        .logo svg {
            width: 40px;
            height: 40px;
        }

        .header { display: table; width: 100%; border-bottom: 1px solid black; }
        .logo, .header-text, .info-boxes { display: table-cell; vertical-align: top; }

        .header-text { text-align: center; }
        .header-text .title { font-size: 11px; font-weight: bold; }

        .info-boxes div {
            border: 1px solid black;
            font-size: 8px;
            text-align: center;
            padding: 2px;
        }

        .recipient-section { display: table; width: 100%; border-bottom: 1px solid black; }
        .recipient-left, .recipient-right { display: table-cell; width: 50%; vertical-align: top; }

        .name-fields, .address-fields, .grades-section {
            display: table;
            width: 100%;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            border-top: 1px solid black;
        }

        .name-field, .address-field, .grade-cell {
            display: table-cell;
            border-right: 1px solid black;
            padding: 2px;
        }

        .rfc-section {
            border: 1px solid black;
            text-align: center;
            font-size: 8px;
            margin-bottom: 2px;
            padding: 2px;
        }

        .amount-section {
            font-size: 9px;
            font-weight: bold;
        }

        .amount-box {
            display: inline-block;
            border: 1px solid black;
            padding: 2px 5px;
            margin: 0 5px;
        }

        table.table-section {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }

        .table-section th, .table-section td {
            border: 1px solid black;
            padding: 2px;
            text-align: center;
        }

        .signature-section {
            display: table;
            width: 100%;
        }

        .signature-box, .stamp-area {
            display: table-cell;
            border: 1px solid black;
            height: 60px;
            font-size: 7px;
            text-align: center;
            vertical-align: bottom;
        }

        .stamp-text {
            writing-mode: vertical-lr;
            text-orientation: mixed;
        }

        .note {
            font-size: 7px;
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <svg width="60" height="60" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" fill="#D4AF37" stroke="#8B6914" stroke-width="2"/>
                    <text x="50" y="30" text-anchor="middle" font-size="12" font-weight="bold" fill="#8B6914">SEP</text>
                    <text x="50" y="70" text-anchor="middle" font-size="8" fill="#8B6914">EDUCACIÓN</text>
                </svg>
            </div>
            <div class="header-text">
                <p>SUBSECRETARÍA DE EDUCACIÓN MEDIA SUPERIOR</p>
                <p>Dirección General de Educación Tecnológica Agropecuaria y Ciencias del Mar</p>
                <div class="title">RECIBO OFICIAL DE COBRO</div>
                <p>R.F.C. SEP 20305778</p>
            </div>
            <div class="info-boxes">
                <div>UR<br><strong>610</strong></div>
                <div>RECIBO No.<br><strong>' . $numero_recibo . '</strong></div>
                <div>FECHA<br><strong>' . $fecha_actual . '</strong></div>
                <div>ENTIDAD FEDERATIVA<br><strong>YUCATÁN</strong></div>
            </div>
        </div>

        <div class="address">
            AVENIDA REPÚBLICA DE ARGENTINA, NUMERO EXTERIOR 28, NUMERO INTERIOR, OFICINA 304, COLONIA CENTRO, C.P. 06010, DELEGACIÓN: CUAUHTÉMOC, ENTIDAD FEDERATIVA: CIUDAD DE MÉXICO
        </div>

        <div class="recipient-section">
            <div class="recipient-left">
                <div style="text-align: center; font-weight: bold; padding: 5px; border-bottom: 1px solid black;">RECIBÍ DE</div>
                <div class="name-fields">
                    <div class="name-field">' . $apellido_paterno . '<br><small>APELLIDO PATERNO</small></div>
                    <div class="name-field">' . $apellido_materno . '<br><small>APELLIDO MATERNO</small></div>
                    <div class="name-field">' . $nombres . '<br><small>NOMBRE(S)</small></div>
                </div>
                <div class="address-fields">
                    <div class="address-field">CONOCIDO<br><small>DOMICILIO</small></div>
                </div>
            </div>
            <div class="recipient-right">
                <div class="rfc-section">R.F.C. y/o MATRÍCULA<br>' . $alumno['numero_control'] . '</div>
                <div class="grades-section">
                    <div class="grade-cell number">' . $alumno['semestre'] . '</div>
                    <div class="grade-cell number">' . $alumno['grupo'] . '</div>
                    <div class="grade-cell number">M</div>
                </div>
                <div class="grades-section">
                    <div class="grade-cell label">GRADO</div>
                    <div class="grade-cell label">GRUPO</div>
                    <div class="grade-cell label">TURNO</div>
                </div>
            </div>
        </div>

        <div class="amount-section">
            LA CANTIDAD DE $<div class="amount-box">' . number_format($total, 2) . '</div>' . $total_letras . '
        </div>

        <table class="table-section">
            <thead>
                <tr>
                    <th>CANTIDAD</th>
                    <th>CLAVE</th>
                    <th>CONCEPTO</th>
                    <th>CUOTA</th>
                    <th>IMPORTE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>' . $cuota['clave'] . '</td>
                    <td>' . strtoupper($cuota['concepto']) . '</td>
                    <td>' . number_format($total, 2) . '</td>
                    <td>' . number_format($total, 2) . '</td>
                </tr>
                <tr class="total-row">
                    <td colspan="4">TOTAL</td>
                    <td>' . number_format($total, 2) . '</td>
                </tr>
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature-box">NOMBRE Y FIRMA DEL CAJERO<br><br><div style="border-top:1px solid #000;">Dr. JORGE CARLOS AZCORRA OSORIO</div></div>
            <div class="signature-box">SELLO Y DATOS IMPRESOS DE LA ESCUELA</div>
            <div class="stamp-area"><div class="stamp-text">RECIBO ORIGINAL INTERESADO DUPLICADO ARCHIVO TRIPLICADO CAJA</div></div>
        </div>

        <div class="note">
            NOTA: CHEQUE DE VALIDEZ COMO COMPROBANTE DE PAGO SÓLO EN EL SELLO DE LA ESCUELA Y FIRMA DEL CAJERO. EXENTO DE I.V.A. CONFORME AL ART. 15 FRACC. IV DE LA LEY DE IMPUESTO AL VALOR AGREGADO
        </div>
    </div>
</body>
</html>
';

// Generar PDF
$mpdf = new \Mpdf\Mpdf([
    'format' => [215.9, 139.7], // 5.5 x 8.5 pulgadas en mm
    'orientation' => 'P',
    'margin_top' => 0,
    'margin_bottom' => 0,
    'margin_left' => 0,
    'margin_right' => 0,
]);
$mpdf->WriteHTML($html);
$mpdf->Output("recibo_{$numero_recibo}.pdf", \Mpdf\Output\Destination::INLINE);

// Guarda el recibo
$fecha_sql = date('Y-m-d');
$stmt = $conn->prepare("INSERT INTO recibos (numero_recibo, numero_control, fecha, total) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssd", $numero_recibo, $alumno['numero_control'], $fecha_sql, $total);
$stmt->execute();
