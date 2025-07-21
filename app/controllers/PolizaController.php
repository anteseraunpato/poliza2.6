<?php
namespace App\Controllers;

require_once __DIR__ . '/../conexion.php';

class PolizaController
{
    public static function guardar()
    {
        global $conn;

        $uuid = $_POST['uuid'] ?? '';
        $rfc_emisor = $_POST['rfc_emisor'] ?? '';
        $total = $_POST['total'] ?? '';
        $capitulo = $_POST['capitulo'] ?? '';
        $partida = $_POST['partida'] ?? '';
        $creador = $_POST['creador'] ?? '';
        $observaciones = $_POST['observaciones'] ?? '';

        // Validación simple
        if (!$uuid || !$rfc_emisor || !$total || !$partida) {
            self::responderError('Faltan datos obligatorios.');
            return;
        }

        // Buscar la partida por denominación
        $sql_partida = "SELECT id, partida, denominacion FROM partidas WHERE denominacion = ?";
        $stmt = $conn->prepare($sql_partida);
        $stmt->bind_param("s", $partida);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row_partida = $result->fetch_assoc();
            $fecha = date("Y-m-d H:i:s");

            $sql_guardar = "INSERT INTO polizas (uuid, rfc_emisor, total, partida, denominacion, observaciones, fecha)
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_guardar = $conn->prepare($sql_guardar);

            if ($stmt_guardar) {
                $stmt_guardar->bind_param(
                    "sssssss",
                    $uuid,
                    $rfc_emisor,
                    $total,
                    $row_partida['id'],
                    $row_partida['denominacion'],
                    $observaciones,
                    $fecha
                );

                if ($stmt_guardar->execute()) {
                    self::responderExito("Datos guardados correctamente.");
                } else {
                    self::responderError("Error al guardar datos.");
                }
            } else {
                self::responderError("Error al preparar la consulta.");
            }
        } else {
            self::responderError("Partida no encontrada.");
        }

        $conn->close();
    }


    //Función para buscar pólizas
    public static function buscarPolizas()
{
    global $conn;

    $anio = $_POST['anio'] ?? '';
    $mes = $_POST['mes'] ?? '';
    $dia = $_POST['dia'] ?? '';
    $poliza = $_POST['poliza'] ?? '';

    $items = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Si se reciben datos para insertar (parece incompleto en tu código, revisa qué campos quieres insertar)
        if ($dia && $mes && $anio) {
            // Aquí faltan variables necesarias, revisa tu lógica de inserción original y adáptala
            // Por ejemplo:
            // $rfc_emisor, $total, $partida, $denominacion, $observaciones deben venir de $_POST o definirse
            // $id = substr(uniqid(), 0, 10);
            // $uuid = uniqid();

            // Por ahora dejamos este bloque comentado o vacio para evitar errores
        }

        // Eliminar registro
        if (isset($_POST['id_eliminar'])) {
            $stmt = $conn->prepare("DELETE FROM polizas WHERE id = ?");
            $stmt->bind_param("s", $_POST['id_eliminar']);
            $stmt->execute();
        }

        // Buscar pólizas
        $query = "SELECT * FROM polizas WHERE 1=1";
        $params = [];
        $types = "";

        if ($anio) {
            $query .= " AND YEAR(fecha) = ?";
            $types .= "i";
            $params[] = $anio;
        }
        if ($mes) {
            $query .= " AND MONTH(fecha) = ?";
            $types .= "i";
            $params[] = $mes;
        }
        if ($dia) {
            $query .= " AND DAY(fecha) = ?";
            $types .= "i";
            $params[] = $dia;
        }
        if ($poliza) {
            $query .= " AND no_poliza = ?";
            $types .= "s";
            $params[] = $poliza;
        }

        $stmt = $conn->prepare($query);
        if ($stmt) {
            if ($params) {
                // Preparar parámetros dinámicos para bind_param (referencias)
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
    }

    return $items;
}


//Función para obtener pólizas por id
public static function obtenerPolizaPorId($id) {
        $conn = Conexion::getConexion();  // Supongo que tienes una clase Conexion con método getConexion()
        $sql = "SELECT fecha, total, subtotal, moneda, rfc_emisor, uuid FROM datos_xml WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public static function obtenerCapitulos() {
        $conn = Conexion::getConexion();
        $sql = "SELECT id, denominacion FROM capitulos";
        return $conn->query($sql);
    }

    public static function obtenerPartidasPorCapitulo($id_capitulo) {
        $conn = Conexion::getConexion();
        $stmt = $conn->prepare("SELECT id, partida, denominacion FROM partidas WHERE id_cap = ?");
        $stmt->bind_param("i", $id_capitulo);
        $stmt->execute();
        return $stmt->get_result();
    }

    private static function responderExito($mensaje)
    {
        echo "<script>alert('$mensaje'); window.history.back();</script>";
    }

    private static function responderError($mensaje)
    {
        echo "<script>alert('$mensaje'); window.history.back();</script>";
    }

    
}
