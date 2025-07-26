<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Pólizas</title>
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .message {
            background-color: #d4edda;
            padding: 10px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            color: #155724;
            margin: 10px auto;
            text-align: center;
            width: 90%;
        }

        .button-link button {
            padding: 5px 10px;
            margin-right: 5px;
        }

        .btn-eliminar {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-eliminar:hover {
            background-color: #c0392b;
        }

        .select-all-btn {
            margin: 15px auto;
            display: block;
            padding: 10px 20px;
            background-color: #004d3b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .select-all-btn:hover {
            background-color: #00664f;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-center">
                <h1>GENERADOR DE PÓLIZAS</h1>
            </div>
            <?php include __DIR__ . '/components/navbar.php'; ?>
        </header>

        <?php if (isset($_GET['message'])) { ?>
            <div class="message"><?= htmlspecialchars($_GET['message']); ?></div>
        <?php } ?>

        <div class="main-content">

            <button class="select-all-btn" onclick="seleccionarTodos()">Seleccionar todos</button>

            <?php
            require_once dirname(__DIR__, 2) . '/conexion.php';

            $sql = "SELECT fecha, total, subtotal, moneda, rfc_emisor, rfc_receptor, uuid, id FROM datos_xml";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
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

            $conn->close();
            ?>
        </div>
    </div>

    <div id="confirmacion" style="display: none;">
        ¿Estás seguro de eliminar este registro?
    </div>

    <script>
        // Ocultar mensaje de éxito
        setTimeout(() => {
            const message = document.querySelector('.message');
            if (message) {
                message.style.display = 'none';
            }
        }, 3000);

        // Seleccionar todos los checkboxes
        function seleccionarTodos() {
            const checkboxes = document.querySelectorAll("input[type='checkbox']");
            checkboxes.forEach((checkbox) => {
                checkbox.checked = true;
            });
        }

        // Confirmación de eliminación
        document.querySelectorAll(".btn-eliminar").forEach((button) => {
            button.addEventListener("click", () => {
                const uuid = button.getAttribute("data-uuid");
                if (confirm("¿Estás seguro de eliminar este registro?")) {
                    window.location.href = "eliminar.php?uuid=" + encodeURIComponent(uuid);
                }
            });
        });
    </script>
</body>
</html>
