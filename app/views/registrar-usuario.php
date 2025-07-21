<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cuenta</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Arial', sans-serif;
            background: #f4f7fc; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #e4e9f2;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: 100%;
            height: 100%;
            padding: 20px;
        }

        .register-box {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .register-box:hover {
            transform: scale(1.05);
            box-shadow: 0 25px 40px rgba(0, 0, 0, 0.15);
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #4A4A4A;
        }

        .textbox {
            margin-bottom: 20px;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .textbox input, .textbox select {
            width: 100%;
            padding: 14px 20px;
            border-radius: 8px;
            border: 2px solid #d1d9e6;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #4A4A4A;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .textbox input:focus, .textbox select:focus {
            border-color: #5c7cfa;
            outline: none;
            background-color: #f3f6fc;
            box-shadow: 0 0 8px rgba(92, 124, 250, 0.3);
        }

        .textbox input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            width: 100%;
        }

        .form-row .textbox {
            width: 48%; /* Dos campos por fila */
        }

        input[type="submit"] {
            width: 100%;
            padding: 16px;
            background-color: #5c7cfa;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #4a68d8;
            transform: translateY(-2px);
        }

        .options {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }

        .options a {
            text-decoration: none;
            color: #5c7cfa;
            font-weight: bold;
        }

        .options a:hover {
            color: #4a68d8;
        }

        .options a:active {
            color: #3e58b0;
        }

        .container {
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body> 
    <div class="container">
        <div class="register-box">
            <h2>Crear Cuenta</h2>
            <form action="registrocontroller.php" method="POST"> 
                <div class="textbox">
                    <input type="text" placeholder="Nombre Completo" name="nombre_completo" required>
                </div>
                <div class="textbox">
                    <input type="text" placeholder="Nombre de Usuario" name="nombre_usuario" required>
                </div>
                <div class="textbox">
                    <input type="email" placeholder="Correo Electrónico" name="correo_electronico" required>
                </div>
                
                <div class="form-row">
                    <div class="textbox">
                        <input type="number" placeholder="Edad" name="edad" required>
                    </div>
                    <div class="textbox">
                        <input type="tel" placeholder="Teléfono" name="telefono" required>
                    </div>
                </div>

                <div class="textbox">
                    <input type="date" placeholder="Fecha de Nacimiento" name="fecha_nacimiento" required>
                </div>

                <div class="form-row">
                    <div class="textbox">
                        <input type="text" placeholder="Localidad" name="localidad" required>
                    </div>
                    <div class="textbox">
                        <select name="genero" required>
                            <option value="" disabled selected>Selecciona tu Género</option>
                            <option value="male">Masculino</option>
                            <option value="female">Femenino</option>
                            <option value="other">Otro</option>
                        </select>
                    </div>
                </div>

                <div class="textbox">
                    <input type="password" placeholder="Contraseña" name="contraseña" required>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="Confirmar Contraseña" name="confirm_password" required>
                </div>

                <!-- Nueva sección para la pregunta y respuesta de seguridad -->
                <div class="textbox">
                    <input type="text" placeholder="Escribe una pregunta" name="pregunta_seguridad" required>
                </div>
                <div class="textbox">
                    <input type="text" placeholder="Respuesta de Seguridad" name="respuesta_seguridad" required>
                </div>

                <div class="textbox">
                    <label>
                        <input type="checkbox" name="terms" required>
                        Acepto los <a href="#">términos y condiciones</a>.
                    </label>
                </div>

                <input type="submit" value="Crear Cuenta">
            </form>
            <div class="options">
                ¿Ya tienes cuenta? <a href="login.php">Iniciar Sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
