<?php
// Configuración segura de rutas de imágenes
$ruta_base = __DIR__;
$logo_sep = $ruta_base.'/public/assets/images/secretaria.png';
$logo_rfc = $ruta_base.'/public/assets/images/rfc.png';

// Asegurar valores para evitar errores
$semestre = str_pad($alumno['semestre'] ?? '00', 2, '0', STR_PAD_LEFT);
$grupo = $alumno['grupo'] ?? '';
$numero_control = $alumno['numero_control'] ?? '';
$apellido_paterno = $alumno['apellido_paterno'] ?? '';
$apellido_materno = $alumno['apellido_materno'] ?? '';
$nombres = $alumno['nombres'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo Oficial de Cobro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            background-color: white;
        }
        
        .container {
            border: 2px solid black;
            width: 800px;
            margin: 0 auto;
        }
        
        .header {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid black;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            margin-right: 15px;
        }
        
        .header-text {
            flex: 1;
            text-align: center;
        }
        
        .header-text h3 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }
        
        .header-text p {
            margin: 2px 0;
            font-size: 10px;
        }
        
        .title {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .info-boxes {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 0;
        }
        
        .info-box {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        
        .info-box.top-left {
            border-right: 1px solid black;
            border-bottom: 1px solid black;
        }
        
        .info-box.top-right {
            border-bottom: 1px solid black;
        }
        
        .info-box.bottom-left {
            border-right: 1px solid black;
        }
        
        .address {
            padding: 5px 10px;
            font-size: 10px;
            border-bottom: 1px solid black;
        }
        
        .recipient-section {
            display: flex;
            border-bottom: 1px solid black;
        }
        
        .recipient-left {
            flex: 1;
            border-right: 1px solid black;
        }
        
        .recipient-right {
            width: 200px;
        }
        
        .name-fields {
            display: flex;
            border-bottom: 1px solid black;
        }
        
        .name-field {
            flex: 1;
            border-right: 1px solid black;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }
        
        .name-field:last-child {
            border-right: none;
        }
        
        .rfc-section {
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: 1fr 1fr;
            height: 60px;
        }
        
        .rfc-top, .rfc-bottom {
            border: 1px solid black;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .rfc-bottom {
            border-top: none;
        }
        
        .address-fields {
            display: flex;
            border-bottom: 1px solid black;
        }
        
        .address-field {
            flex: 1;
            border-right: 1px solid black;
            padding: 15px 8px;
            text-align: center;
            font-weight: bold;
        }
        
        .address-field:last-child {
            border-right: none;
        }
        
        .grades-section {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            height: 60px;
        }
        
        .grade-cell {
            border: 1px solid black;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .grade-cell.number {
            border-bottom: none;
        }
        
        .grade-cell.label {
            border-top: none;
        }
        
        .amount-section {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid black;
            font-weight: bold;
        }
        
        .amount-box {
            border: 1px solid black;
            padding: 5px 10px;
            margin-left: 10px;
            margin-right: 20px;
        }
        
        .table-section {
            border-collapse: collapse;
            width: 100%;
        }
        
        .table-section th,
        .table-section td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        
        .table-section th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .total-row {
            font-weight: bold;
        }
        
        .signature-section {
            display: flex;
            height: 120px;
        }
        
        .signature-box {
            flex: 1;
            border: 1px solid black;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10px;
        }
        
        .signature-box:first-child {
            border-right: none;
        }
        
        .signature-label {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .signature-line {
            border-top: 1px solid black;
            margin-top: 60px;
            padding-top: 5px;
            text-align: center;
            font-weight: bold;
        }
        
        .stamp-area {
            width: 150px;
            border: 1px solid black;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background-color: #f8f8f8;
        }
        
        .stamp-text {
            writing-mode: vertical-lr;
            text-orientation: mixed;
            font-size: 10px;
            text-align: center;
        }
        
        .note {
            padding: 5px 10px;
            font-size: 9px;
            text-align: justify;
            line-height: 1.2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="<?= $logo_sep ?>" alt="Logo SEP" width="110" height="60">
            </div>
            <div class="header-text">
                <p>SUBSECRETARÍA DE EDUCACIÓN MEDIA SUPERIOR</p>
                <p>Dirección General de Educación Tecnológica Agropecuaria y Ciencias del Mar</p>
                <div class="title">RECIBO OFICIAL DE COBRO</div>
                <p>R.F.C. SEP 20305778</p>
            </div>
            <div class="info-boxes">
                <div class="info-box top-left">
                    <div>UR</div>
                    <div style="font-weight: bold;">610</div>
                </div>
                <div class="info-box top-right">
                    <div>RECIBO No.</div>
                    <div style="font-weight: bold;">DGETAYCM 7950514</div>
                </div>
                <div class="info-box bottom-left">
                    <div>FECHA</div>
                    <div style="font-weight: bold;">13-jul-25</div>
                </div>
                <div class="info-box bottom-right">
                    <div>ENTIDAD FEDERATIVA</div>
                    <div style="font-weight: bold;">YUCATÁN</div>
                </div>
            </div>
        </div>

        <div class="address">
            AVENIDA REPÚBLICA DE ARGENTINA, NUMERO EXTERIOR 28, NUMERO INTERIOR, OFICINA 304,<br>
            COLONIA, CENTRO, C.P. 06010, DELEGACIÓN: CUAUHTÉMOC, ENTIDAD FEDERATIVA: CIUDAD DE MÉXICO
        </div>

        <div class="recipient-section">
            <div class="recipient-left">
                <div style="text-align: center; font-weight: bold; padding: 5px; border-bottom: 1px solid black;">
                    RECIBÍ DE
                </div>
                <div class="name-fields">
                    <div class="name-field">
                        <?= htmlspecialchars($apellido_paterno) ?><br>
                        <small>APELLIDO PATERNO</small>
                    </div>
                    <div class="name-field">
                        <?= htmlspecialchars($apellido_materno) ?><br>
                        <small>APELLIDO MATERNO</small>
                    </div>
                    <div class="name-field">
                        <?= htmlspecialchars($nombres) ?><br>
                        <small>NOMBRE (S)</small>
                    </div>
                </div>
                <div class="address-fields">
                    <div class="address-field">
                        CONOCIDO<br>
                        <small>DOMICILIO</small>
                    </div>
                </div>
            </div>
            <div class="recipient-right">
                <div class="rfc-section">
                    <div class="rfc-top">R.F.C. y/o MATRICULA</div>
                    <div class="rfc-bottom"><?= htmlspecialchars($numero_control) ?></div>
                </div>
                <div class="grades-section">
                    <div class="grade-cell number"><?= substr($semestre, 0, 1) ?></div>
                    <div class="grade-cell number"><?= substr($semestre, 1, 1) ?></div>
                    <div class="grade-cell number"><?= htmlspecialchars($grupo) ?></div>
                    <div class="grade-cell number">M</div>
                    <div class="grade-cell label">GRADO</div>
                    <div class="grade-cell label"></div>
                    <div class="grade-cell label">GRUPO</div>
                    <div class="grade-cell label">TURNO</div>
                </div>
            </div>
        </div>

        <div class="amount-section">
            LA CANTIDAD DE $
            <div class="amount-box">3,500.00</div>
            TRES MIL QUINIENTOS PESOS 00/100
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
                    <td>B003</td>
                    <td>BENEFICIOS (FEBRERO 2025)</td>
                    <td>3,500.00</td>
                    <td>3,500.00</td>
                </tr>
                <tr>
                    <td>0</td>
                    <td>0</td>
                    <td>#¡REF!</td>
                    <td>0.00</td>
                    <td>0.00</td>
                </tr>
                <tr class="total-row">
                    <td colspan="4">TOTAL</td>
                    <td>3,500.00</td>
                </tr>
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-label">NOMBRE Y FIRMA DEL CAJERO</div>
                <div class="signature-line">Dr. JORGE CARLOS AZCORRA OSORIO</div>
            </div>
            <div class="signature-box">
                <div class="signature-label">SELLO Y DATOS IMPRESOS DE LA ESCUELA</div>
            </div>
            <div class="stamp-area">
                <div class="stamp-text">
                    <img src="<?= $logo_rfc ?>" alt="Logo SEP" width="170" height="120">
                </div>
            </div>
        </div>

        <div class="note">
            NOTA: CHEQUE DE VALIDEZ COMO COMPROBANTE DE PAGO SÓ EN EL SELLO DE LA ESCUELA Y FIRMA DEL CAJERO EXENTO DE I.V.A. CONFORME AL ART. 15 FRACC. IV DE LA LEY DE IMPUESTO AL VALOR AGREGADO
        </div>
    </div>
</body>
</html>