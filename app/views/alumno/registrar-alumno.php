<?php require_once '../../../conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Alumno</title>
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
    </style>
</head>

<body>

    <h2>Agregar Alumno</h2>

    <form action="../alumno/alumno-action.php" method="POST">
        <label>Número de Control:</label>
        <input type="text" name="numero_control" required>

        <label>Nombre del Alumno:</label>
        <input type="text" name="nombre_alumno" required>

        <label>Semestre:</label>
        <input type="text" name="semestre" required>

        <label>Grupo:</label>
        <input type="text" name="grupo" required>

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