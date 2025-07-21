<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Pólizas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .header {
            display: flex;
            align-items: center;
            background-color: #007bff;
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
        .header-right {
            display: flex;
            justify-content: flex-end;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .message {
            background-color: #28a745;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 5px;
            display: none;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .table-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input[type="checkbox"] {
            margin: 0;
            padding: 0;
            width: 20px;
            height: 20px;
        }
        .button-link {
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            background-color: #007bff;
        }
        .button-link:hover {
            background-color: #0056b3;
        }
        #confirmacion {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
    <script>
        // Ocultar el mensaje después de 3 segundos
        setTimeout(() => {
            const message = document.querySelector('.message');
            if (message) {
                message.style.display = 'none';
            }
        }, 3000);

        // Agregar un botón para seleccionar todos los elementos
        const selectAllButton = document.createElement("button");
        selectAllButton.textContent = "Seleccionar todos";
        selectAllButton.onclick = () => {
            const checkboxes = document.querySelectorAll("input[type='checkbox']");
            checkboxes.forEach((checkbox) => {
                checkbox.checked = true;
            });
        };
        document.body.appendChild(selectAllButton);
    </script>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-left">
                <img src="imagen2.jpg" alt="Imagen de usuario" class="user-img">
            </div>
            <div class="header-center">
                <h1>GENERADOR DE PÓLIZAS</h1>
            </div>
            <div class="header-right">
                <a href="/index.php" class="button-link">
                    <button>Regresar</button>
                </a>
            </div>
        </header>

        <?php if (isset($_GET['message'])) { ?>
            <div class="message" style="display: block;"><?= $_GET['message']; ?></div>
        <?php } ?>

        <div class="main-content">
            <?php
            require_once 'conexion.php'; // Reemplaza la conexión local
            ?>

            // Consulta SQL para seleccionar datos de la tabla "datos_xml"
            $sql = "SELECT fecha, total, subtotal, moneda, rfc_emisor, rfc_receptor, uuid, id FROM datos_xml";

            // Ejecutar consulta
            $result = $conn->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Mostrar datos en un cuadro pequeño
                echo "<div class='table-container'>";
                echo "<table>";
                echo "<tr>";
                echo "<th>Fecha</th>";
                echo "<th>Total</th>";
                echo "<th>Subtotal</th>";
                echo "<th>Moneda</th>";
                echo "<th>RFC Emisor</th>";
                echo "<th>RFC Receptor</th>";
                echo "<th>UUID</th>";
                echo "<th>Acciones</th>";
                echo "</tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["fecha"] . "</td>";
                    echo "<td>" . $row["total"] . "</td>";
                    echo "<td>" . $row["subtotal"] . "</td>";
                    echo "<td>" . $row["moneda"] . "</td>";
                    echo "<td>" . $row["rfc_emisor"] . "</td>";
                    echo "<td>" . $row["rfc_receptor"] . "</td>";
                    echo "<td>" . $row["uuid"] . "</td>";
                    echo "<td>";
                    echo "<a href='editar.php?id=" . $row['id'] . "' class='button-link'><button>Editar</button></a>";
                    echo "<button class='btn-eliminar' data-uuid='" . $row["uuid"] . "'>Eliminar</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "No hay resultados";
            }

            // Cerrar conexión
            $conn->close();
            ?>
        </div>
    </div>

    <div id="confirmacion" style="display: none;">
        ¿Estás seguro de eliminar este registro?
    </div>
    <script>
        // Agregar evento de clic a los botones de eliminar
        document.querySelectorAll(".btn-eliminar").forEach((button) => {
            button.addEventListener("click", () => {
                const uuid = button.getAttribute("data-uuid");
                // Mostrar el mensaje de confirmación
                if (confirm("¿Estás seguro de eliminar este registro?")) {
                    // Redireccionar a la página de eliminación
                    window.location.href = "eliminar.php?uuid=" + uuid;
                }
            });
        });
    </script>
</body>
</html>