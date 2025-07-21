<?php
// Mantener los valores de filtro en el formulario
$anio = $_POST['anio'] ?? '';
$mes = $_POST['mes'] ?? '';
$dia = $_POST['dia'] ?? '';
$poliza = $_POST['poliza'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Póliza</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css">
    <link rel="icon" href="favicon.ico">
</head>
<body>
    <header class="header">
        <div class="header-left">
            <img src="imagen2.jpg" alt="Imagen de usuario" class="user-img" style="width: 50px; height: 50px; border-radius: 50%;">
        </div>  
        <div class="header-center">
            <h1>GENERADOR DE PÓLIZAS</h1>
        </div>
        <div class="header-right">
            <button class="menu-btn" onclick="toggleMenu()">&#9776;</button>
            <div class="menu" id="menu">
                <a href="./registro.php">Registrar usuario</a>
                <a href="login.php">SALIR</a>
            </div>
        </div>
    </header>

    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            color: white;
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
            color: white;
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
            color: white;
        }
    </style>

    <script>
        function toggleMenu() {
            var menu = document.getElementById("menu");
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }
    </script>

    <div class="container mt-4">
        <h2>Buscar Póliza</h2>
        <form method="POST" action="buscar_poliza_action.php">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Año</label>
                    <input type="text" name="anio" class="form-control" value="<?php echo htmlspecialchars($anio); ?>" placeholder="Ejemplo: 2024">
                </div>
                <div class="form-group col-md-3">
                    <label>Mes</label>
                    <select id="mes" name="mes" class="form-control">
                        <option value="">Seleccione</option>
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo ($i == $mes) ? 'selected' : ''; ?>>
                                <?php echo $i; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Día</label>
                    <select id="dia" name="dia" class="form-control">
                        <option value="">Seleccione</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo ($i == $dia) ? 'selected' : ''; ?>>
                                <?php echo $i; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Número de Póliza</label>
                    <input type="text" name="poliza" class="form-control" value="<?php echo htmlspecialchars($poliza); ?>" placeholder="Número de póliza">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <h3 class="mt-4">Pólizas Añadidas</h3>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Fecha</th>
                    <th>ID</th>
                    <th>UUID</th>
                    <th>RFC Emisor</th>
                    <th>Total</th>
                    <th>Partida</th>
                    <th>Denominación</th>
                    <th>Observaciones</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($item['id']); ?></td>
                            <td><?php echo htmlspecialchars($item['uuid']); ?></td>
                            <td><?php echo htmlspecialchars($item['rfc_emisor']); ?></td>
                            <td><?php echo "$" . number_format($item['total'], 2); ?></td>
                            <td><?php echo htmlspecialchars($item['partida']); ?></td>
                            <td><?php echo htmlspecialchars($item['denominacion']); ?></td>
                            <td><?php echo htmlspecialchars($item['observaciones']); ?></td>
                            <td>
                                <form method="POST" action="buscar_poliza_action.php" onsubmit="return confirm('¿Estás seguro de eliminar esta póliza?');">
                                    <input type="hidden" name="id_eliminar" value="<?php echo htmlspecialchars($item['id']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center">No se encontraron pólizas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
