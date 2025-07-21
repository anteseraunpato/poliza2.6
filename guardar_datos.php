<?php
require_once 'conexion.php'; // Reemplaza la conexión local



// Obtener el ID del XML seleccionado por el usuario
if (isset($_POST['id_xml'])) {
  $id_xml = $_POST['id_xml'];
} else {
  echo 'No se ha enviado el ID del XML';
  exit;
}

// Obtener el XML seleccionado por el usuario
$sql = "SELECT * FROM xmls_subidos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_xml);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $ruta_xml = $row['ruta_xml'];

  // Cargar el XML
  $file_factura = array("tmp_name" => $ruta_xml);
  $xml_content = file_get_contents($file_factura["tmp_name"]);

  // Reemplazar etiquetas y atributos
  $xml_content = str_replace("<tfd:", "<cfdi:", $xml_content);
  $xml_content = str_replace("<cfdi:", "<", $xml_content);
  $xml_content = str_replace("</cfdi:", "</", $xml_content);

  $xml_content = str_replace("<nomina12:", "<", $xml_content);
  $xml_content = str_replace("</nomina12:", "</", $xml_content);
  $xml_content = str_replace("<nomina11:", "<", $xml_content);
  $xml_content = str_replace("</nomina11:", "</", $xml_content);

  $xml_content = str_replace("<pago10:", "<", $xml_content);
  $xml_content = str_replace("</pago10:", "</", $xml_content);

  $xml_content = str_replace("@attributes", "attributes", $xml_content);

  // Cargar el XML en un objeto
  $xml_content = simplexml_load_string(mb_convert_encoding($xml_content, 'UTF-8', 'auto'));

  // Convertir el objeto a un arreglo
  $xml_content = (array) $xml_content;

  // Extraer los datos del XML
  $xml_data["fecha"] = $xml_content["@attributes"]["Fecha"];
  $xml_data["total"] = $xml_content["@attributes"]["Total"];
  $xml_data["subtotal"] = $xml_content["@attributes"]["SubTotal"];
  $xml_data["moneda"] = $xml_content["@attributes"]["Moneda"];

  $xml_content["Emisor"] = (array) $xml_content["Emisor"];
  $xml_content["Receptor"] = (array) $xml_content["Receptor"];
  $xml_content["Complemento"] = (array) $xml_content["Complemento"];
  $xml_content["Complemento"]["TimbreFiscalDigital"] = (array) $xml_content["Complemento"]["TimbreFiscalDigital"];

  $xml_data["rfc_emisor"] = $xml_content["Emisor"]["@attributes"]["Rfc"];
  $xml_data["rfc_receptor"] = $xml_content["Receptor"]["@attributes"]["Rfc"];
  $xml_data["uuid"] = $xml_content["Complemento"]["TimbreFiscalDigital"]["@attributes"]["UUID"];

  // Verificar la existencia de los datos antes de guardar
  $sql = "SELECT * FROM datos_xml WHERE uuid = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $xml_data["uuid"]);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo 'Los datos del XML ya existen en la base de datos.';
    exit;
  }

  // Guardar los datos del XML en la base de datos
  $sql = "INSERT INTO datos_xml (fecha, total, subtotal, moneda, rfc_emisor, rfc_receptor, uuid) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sssssss", $xml_data["fecha"], $xml_data["total"], $xml_data["subtotal"], $xml_data["moneda"], $xml_data["rfc_emisor"], $xml_data["rfc_receptor"], $xml_data["uuid"]);
  $stmt->execute();

  // Devolver respuesta JSON
  $response = array(
    'success' => true,
    'message' => 'Datos guardados correctamente'
  );

  echo json_encode($response);
} else {
  echo 'No se encontró el XML seleccionado.';
}

// Cerrar conexión a la base de datos
$conn->close();
?>