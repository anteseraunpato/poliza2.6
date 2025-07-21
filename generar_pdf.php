<?php
// Recibir los datos
$uuid = $_POST['uuid'];
$rfc_emisor = $_POST['rfc_emisor'];
$total = $_POST['total'];
$capitulo = $_POST['capitulo'];
$partida = $_POST['partida'];
$partida_codigo = $_POST['partida_codigo'];
$observacion = $_POST['observacion'];
$elaborador = $_POST['elaborador'];
$creador = $_POST['creador'];
$verificador = $_POST['verificador'];

// Crear el PDF
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();

// Agregar el título
$mpdf->SetTitle('Póliza ' . $uuid);

// Agregar el contenido
$html = '
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }
    .container {
      border: 1px solid #ccc;
      max-width: 800px;
      margin: 0 auto;
      position: relative;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #ccc;
    }
    .logo {
      display: flex;
      align-items: center;
    }
    .logo img {
      height: 60px;
      margin-right: 10px;
    }
    .logo-text {
      font-size: 10px;
      color: #666;
    }
    .policy-number {
      border: 1px solid black;
      padding: 5px;
      text-align: center;
    }
    .date {
      text-align: right;
      padding: 10px;
      font-size: 12px;
    }
    .content {
      padding: 20px;
    }
    .recipient {
      margin-bottom: 100px;
    }
    .amount {
      text-align: right;
      font-weight: bold;
    }
    .connectors {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      pointer-events: none;
    }
    .connector {
      position: absolute;
      background-color: #000;
      width: 0px;
      height: 10px;
      border-radius: 50%;
    }
    .connector-left {
      left: -5px;
      top: 100px;
    }
    .connector-right {
      right: -5px;
      top: 100px;
    }
    .section {
      margin: 10px 0 20px 0;
      border-bottom: 1px solid #ccc;
    }
    .section-header {
      background-color: #89cff0;
      padding: 5px;
      font-weight: bold;
    }
    .section-content {
      padding: 10px;
      margin-bottom: 10px;
      border-bottom: 1px solid #ccc;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      border: 1px solid #ccc;
      display: inline-block;
      vertical-align: top;
      margin-bottom: 10px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 5px;
      text-align: left;
    }
    th {
      background-color: #89cff0;
      padding: 5px;
      font-weight: bold;
    }
    .footer {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      flex-direction: row;
    }
    .footer-section {
      text-align: center;
      width: 33.33%;
      padding: 5px;
      border: 1px solid black;
    }
  </style>
  <div class="container">
    <div class="header">
      <div class="logo">
        <img src="Secretaria.jpg" alt="EDUCACIÓN Logo">
        <div class="logo-text">
          SECRETARÍA DE EDUCACIÓN PÚBLICA<br>
          CBTA 284
        </div>
      </div>
      <div class="policy-number">
        Póliza ' . $uuid . '
      </div>
    </div>
    <div class="content">
      <div class="section">
        <div class="section-header">
          Información de la póliza
        </div>
        <div class="section-content">
          <p>RFC Emisor: ' . $rfc_emisor . '</p>
          <p>Total: ' . $total . '</p>
          <p>Capítulo: ' . $capitulo . '</p>
          <p>Partida: ' . $partida . '</p>
        </div>
      </div>
      <div class="section">
        <div class="section-header">
          Detalle de la partida
        </div>
        <div class="section-content">
          <table>
            <tr>
              <th>PARTIDA DE GASTO</th>
              <th>DENOMINACIÓN</th>
              <th>CARGO</th>
            </tr>
            <tr>
              <td>' .$partida_codigo. '</td>
              <td>' . $partida . '</td>
              <td>' . $total . '</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="section">
        <div class="section-header">DENOMINACIÓN DE PAGO</div>
        <div class="section-content">
          <table>
            <tr>
              <th>EFECTIVO</th>
              <th>ABONO</th>
            </tr>
            <tr>
              <td>' . $total . '</td>
              <td>' . $total . '</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="section">
        <div class="section-header">OBSERVACIONES</div>
        <div class="section-content">
          <table>
            <tr>
              <th>OBSERVACIONES</th>
            </tr>
            <tr>
              <td>' . $observacion . '</td>
            </tr>
          </table>
        </div>
      </div>
      <div class="section">
        <div class="section-content">
          <table>
            <tr>
              <th>ELABORADOR POR:</th>
              <th>AUTORIZADO POR:</th>
              <th>REGISTRO EN EL LIBRO</th>
            </tr>
            <tr>
              <td>' . $elaborador . '</td>
              <td>' . $creador . '</td>
              <td>' . $verificador . '</td>
            </tr>
          </table>
        </div>
    
    </div>
  </div>
';

// Agregar el contenido al PDF
$mpdf->WriteHTML($html);

// Generar el PDF
$mpdf->Output('poliza_' . $uuid . '.pdf', 'D');
?>