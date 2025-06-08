<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "123456789");
define("DB_NAME", "confiteria_mielissimo");

try {
    $conexion = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    echo json_encode(["error" => "Error de conexión a la base de datos: " . $e->getMessage()]);
    http_response_code(500);
    exit;
}

// Verificar método de solicitud
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Método no permitido"]);
    http_response_code(405);
    exit;
}

// Obtener datos del JSON enviado por el cliente
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Validar JSON recibido
if (!$data) {
    echo json_encode(["error" => "Datos no válidos: " . json_last_error_msg()]);
    http_response_code(400);
    exit;
}

// Validar que se envió `nombre` y `activo`
if (!isset($data["txtNombre"]) || !isset($data["activo1"])) {
    echo json_encode(["error" => "Faltan campos obligatorios"]);
    http_response_code(400);
    exit;
}

// Insertar marca en la base de datos
$query = "INSERT INTO marcas (nombre, activo) VALUES (:nombre, :activo)";
$stmt = $conexion->prepare($query);

try {
    $stmt->execute([
        ":nombre" => $data["txtNombre"],
        ":activo" => $data["activo1"]
    ]);

    echo json_encode(["mensaje" => "Marca registrada exitosamente"]);
    http_response_code(201);
} catch (Exception $e) {
    echo json_encode(["error" => "Error al registrar la marca: " . $e->getMessage()]);
    http_response_code(500);
}
?>
