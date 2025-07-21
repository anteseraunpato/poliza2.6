<?php
require_once 'conexion.php'; // Reemplaza la conexión local
 
  // Procesar la subida del XML
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['xmlFile'])) {
    $xmlTmpName = $_FILES['xmlFile']['tmp_name'];
    $xmlName = $_FILES['xmlFile']['name'];
    $uploadDir = 'uploads/xml/';

    // Asegurar que el directorio exista
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    // Mover el archivo al directorio de uploads
    if (move_uploaded_file($xmlTmpName, $uploadDir . $xmlName)) {
      $message = "XML subido exitosamente!";

      // Guardar información en la base de datos
      $nombreXML = basename($xmlName);
      $rutaXML = $uploadDir . $xmlName;
      $id_usuario = 1; // Ajustar según el usuario autenticado

      $sql = "INSERT INTO xmls_subidos (nombre_xml, ruta_xml, id_usuario) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssi", $nombreXML, $rutaXML, $id_usuario);
      $stmt->execute();
      $stmt->close();

      // Redirigir para evitar reenvío del formulario
      header("Location: index.php?upload=success");
      exit;
    } else {
      $message = "Hubo un error al subir el XML.";
    }
  }

  // Eliminar XML seleccionado
  if (isset($_POST['eliminar'])) {
    if (!empty($_POST['rutaXML'])) {
      $rutaXML = $_POST['rutaXML'];
      // Eliminar archivo físico
      if (file_exists($rutaXML)) {
        unlink($rutaXML);
      }

      // Eliminar registro de la base de datos
      $sql = "DELETE FROM xmls_subidos WHERE ruta_xml = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $rutaXML);
      $stmt->execute();
      $stmt->close();

      // Redirigir para evitar reenvío del formulario
      header("Location: index.php?eliminar=success");
      exit;
    }
  }

  // Guardar datos
  if (isset($_POST['guardar_poliza'])) {
    $idXML = $_POST['id_xml'];
    // Guardar datos en la base de datos
    $sql = "INSERT INTO polizas (id_xml) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idXML);
    $stmt->execute();
    $stmt->close();

    // Redirigir para evitar reenvío del formulario
    header("Location: index.php?guardar=success");  
    exit;
  }

  // Obtener los XMLs subidos por el usuario
  $sql = "SELECT * FROM xmls_subidos WHERE id_usuario = 1";
  $result = $conn->query($sql);

  if (!$result) {
    die("Error en la consulta: " . $conn->error);
  }
  ?>

  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Pólizas</title>
    <style>

      :root{
    --verdepino: #004d3b;
    --verde: #00b389;
    --verdepastel: #e2f1da;
    --verdepino-muted: #3e8672;
    --hueso: #fffaec;
    --lavanda: #d5c4fd;
    --lima: #d5f27e;
    --blanco: #f5f5f5;
    --negro: #222;
    --gris: #555;
    --gris-claro: #b2b2b2;
}

      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100vh;
        background-color: #f5f5f5;
      }
      .header {
        display: flex;
        align-items: center;
        background-color: #f5f5f5;
        color: white;
        padding: 15px;
        border-radius: 5px;
      }
      .user-img {
        width: 60px;
        height: 60px;
        border-radius: 60%;
      }
      .header-center {
        flex: 1;
        text-align: center;
      }
      .main-content {
        flex-grow: 1;
        padding: 20px;
      }
      .btn-container {
        position: fixed;
        bottom: 20px;
        width: 100%;
        display: flex;
        justify-content: space-around;
      }
      .btn {
        background-color: #004d3b;
        color: #f5f5f5;
        padding: 20px 30px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }
      .btn:hover {
        background-color: #0056b3;
      }
      .hidden {
        display: none;
      }
      .pdf-list {
        margin-top: 20px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
      }
      .pdf-item {
        padding: 10px;
        border: 1px solid #00b389;
        background: white;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 150px;
        height: 150px;
        justify-content: center;
      }
      .pdf-item a {
        text-decoration: none;
        color: rgb(0, 0, 0);
        font-weight: bold;
      }
      .pdf-item a:hover {
        color: #004d3b;
      }
      .eliminar-btn {
        background-color: #dc3545;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }
      .eliminar-btn:hover {
        background-color: #c82333;
      }
      .checkbox-container {
        margin-bottom: 10px;
      }
      #mensajeGuardado {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #007bff;
        color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      }

            .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f5f5f5;
        color: #004d3b;
        padding: 15px;
        border-radius: 5px;
        position: relative;
      }
      .header-right {
        position: relative;
      }
      .menu-btn {
        background: none;
        border: none;
        color: #00b389;
        font-size: 24px;
        cursor: pointer;
      }
      .menu {
        display: none;
        position: absolute;
        top: 50px;
        right: 0;
        background-color: white;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        overflow: hidden;
      }
      .menu a {
        display: block;
        padding: 10px;
        color: black;
        text-decoration: none;
        text-align: center;
      }
      .menu a:hover {
        background-color: #007bff;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <header class="header">
      <div class="header-center">
        <h1>GENERADOR DE PÓLIZAS</h1>
      </div>
      <div class="header-right">
        <div class="header-right">
        <button class="menu-btn" onclick="toggleMenu()">&#9776;</button>
        <div class="menu" id="menu">
        <a href="/app/views/registrar-usuario.php">Registro de usuarios</a>
        <a href="/app/views/generar-poliza.php">Generar Poliza</a>
        <a href="login.php">Cerrar sesión</a>
        </div>
      </div>
      </div>
    </header>
    <script>
      function toggleMenu() {
        var menu = document.getElementById("menu");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
      }
    </script>

    <div class="main-content">
      <h2>XML Subidos</h2>
      <form action="index.php" method="POST">
        <div class="pdf-list">
          <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="pdf-item">
              <div class="checkbox-container">
                <input 
                  type="radio" 
                  name="id_xml" 
                  value="<?= $row['id']; ?>" 
                  onchange="actualizarIdXML(this.value)"
                >
              </div>
              <a href="<?= $row['ruta_xml']; ?>" target="_blank"><?= $row['nombre_xml']; ?></a>
              <form action="index.php" method="POST">
                <input type="hidden" name="rutaXML" value="<?= $row['ruta_xml']; ?>">
                <button type="submit" name="eliminar" class="eliminar-btn">Eliminar</button>
              </form>
            </div>
          <?php } ?>
        </div>
      </form>
    </div>

    <div class="btn-container">
      <form action="index.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="xmlFile" id="xmlUpload" class="hidden" accept=".xml" onchange="this.form.submit()" />
        <button type="button" class="btn" onclick="document.getElementById('xmlUpload').click()">SUBIR XML</button>
      </form>
      <form id="formGenerarPoliza" onsubmit="guardarDatos()" method="POST">
        <input type="hidden" name="id_xml" id="idXMLSeleccionado" value="">
        <button type="submit" class="btn" onclick="mostrarMensajeGuardado()">GUARDAR DATOS</button>
      </form>
      <script>
  function actualizarIdXML(id) {
    document.getElementById('idXMLSeleccionado').value = id;
  }
  function mostrarMensajeGuardado() {
        Swal.fire({
          title: "¡Éxito!",
          text: "Los datos se han guardado correctamente.",
          icon: "success",
          confirmButtonText: "Aceptar"
        });
      }
  function guardarDatos() {
  console.log("Se está ejecutando la función guardarDatos()");
  var idXML = document.getElementById('idXMLSeleccionado').value;
  var formData = new FormData();
  formData.append('id_xml', idXML);

  fetch('guardar_datos.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      console.log("Se recibió la respuesta del servidor:", data);
      // Redireccionamos a la página index.php?guardar=success
      window.location.href = 'index.php?guardar=success';
  })
  .catch(error => console.error('Error:', error));

  return false; // Agregar esta línea para evitar que el formulario se envíe de manera tradicional
  }
</script> 
    </div>
    <script>
      // Agregar evento de clic a los botones de eliminar
      document.querySelectorAll(".eliminar-btn").forEach((button) => {
        button.addEventListener("click", () => {
          const rutaXML = button.parentNode.querySelector("input[name='rutaXML']").value;
          // Mostrar el mensaje de confirmación
          if (confirm("¿Estás seguro de eliminar este registro?")) {
            // Enviar el formulario de eliminación
            button.parentNode.submit();
          }
        });
      });
    </script>

    <script>
      // Mostrar mensaje de confirmación al cargar la página
      if (window.location.href.includes("upload=success")) {
        Swal.fire({
          title: "¡Éxito!",
          text: "El archivo XML se ha subido correctamente.",
          icon: "success",
          confirmButtonText: "Aceptar"
        });
      }

      if (window.location.href.includes("eliminar=success")) {
        Swal.fire({
          title: "¡Éxito!",
          text: "El archivo XML se ha eliminado correctamente.",
          icon: "success",
          confirmButtonText: "Aceptar"
        });
      }

      if (window.location.href.includes("guardar=success")) {
        Swal.fire({
          title: "¡Éxito!",
          text: "Los datos se han guardado correctamente.",
          icon: "success",
          confirmButtonText: "Aceptar"
        });
      }
    </script>
  </body>
  </html>