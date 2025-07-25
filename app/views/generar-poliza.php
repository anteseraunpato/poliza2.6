<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Pólizas</title>
    <link rel="stylesheet" href="/public/assets/css/styles.css">
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
            <div class="header-center">
                <h1>GENERADOR DE PÓLIZAS</h1>
            </div>
<?php include __DIR__ . '/app/views/components/navbar.php'; ?>
        </header>

        <?php if (isset($_GET['message'])) { ?>
            <div class="message" style="display: block;"><?= htmlspecialchars($_GET['message']); ?></div>
        <?php } ?>

        <div class="main-content">
            <?php
            require_once dirname(__DIR__, 2) . '/conexion.php';

            // Consulta SQL para seleccionar datos de la tabla "datos_xml"
            $sql = "SELECT fecha, total, subtotal, moneda, rfc_emisor, rfc_receptor, uuid, id FROM datos_xml";
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
                    echo "<td>" . htmlspecialchars($row["fecha"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["total"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["subtotal"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["moneda"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["rfc_emisor"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["rfc_receptor"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["uuid"]) . "</td>";
                    echo "<td>";
                    echo "<a href='/editar.php?id=" . htmlspecialchars($row['id']) . "' class='button-link'><button>Editar</button></a>";
                    echo "<button class='btn-eliminar' data-uuid='" . htmlspecialchars($row["uuid"]) . "'>Eliminar</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p>No hay resultados</p>";
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
                    window.location.href = "eliminar.php?uuid=" + encodeURIComponent(uuid);
                }
            });
        });
    </script>
</body>
</html>