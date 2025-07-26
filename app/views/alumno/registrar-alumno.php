<?php require_once '../../../conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Alumno</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/public/assets/css/styles.css">
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background-color: #f5f5f5;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 500px;
            margin: auto;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #004d3b;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #00664f;
        }

        .header {
            background-color: #004d3b;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="header-center">
            <h1>GENERADOR DE PÓLIZAS</h1>
        </div>
        <?php include __DIR__ . '/../../views/components/navbar.php'; ?>
    </header>

    <h2 style="text-align: center;">Agregar Alumno</h2>

    <form action="../alumno/alumno-action.php" method="POST">
        <label>Número de Control:</label>
        <input type="text" name="numero_control" required>

        <label>Nombre del Alumno:</label>
        <input type="text" name="nombre_alumno" required>

        <label>Semestre:</label>
        <select name="semestre" required>
            <option value="">Seleccione el semestre</option>
            <option value="1">1°</option>
            <option value="2">2°</option>
            <option value="3">3°</option>
            <option value="4">4°</option>
            <option value="5">5°</option>
            <option value="6">6°</option>
        </select>

        <label>Grupo:</label>
        <select name="grupo" required>
            <option value="">Seleccione un grupo</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">C</option>
        </select>

        <!-- Cambia el input de especialidad por un select -->
        <label>Especialidad:</label>
        <select name="especialidad" required>
            <option value="">Seleccione una especialidad</option>
            <option value="SAETA">SAETA</option>
            <option value="SYM">SYM</option>
            <option value="AGROP">AGROP</option>
        </select>

        <button type="submit">Guardar Alumno</button>
    </form>

</body>

</html>
