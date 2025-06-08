<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de conexión a la base de datos
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "123456789");
define("DB_NAME", "confiteria_mielissimo");

try {
    // Conexión a la base de datos con PDO
    $conexion = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (Exception $e) {
    echo json_encode(["error" => "Error de conexión a la base de datos: " . $e->getMessage()]);
    http_response_code(500);
    exit;
}

// Verificar el método de solicitud
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Método no permitido"]);
    http_response_code(405);
    exit;
}

// Obtener los datos del JSON enviado por el cliente
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Verificar si el JSON es válido
if (!$data) {
    echo json_encode(["error" => "Datos no válidos: " . json_last_error_msg()]);
    http_response_code(400);
    exit;
}

// Validar datos obligatorios
$requiredFields = ["codigo", "nom", "stock", "prc_compra", "prc_venta", "id_mrc"];
foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        echo json_encode(["error" => "Falta el campo: " . $field]);
        http_response_code(400);
        exit;
    }
}

// Insertar el producto en la base de datos
$query = "INSERT INTO productos (nombre, stock, stock_minimo, precio_compra, precio_venta, fecha_venc, observaciones, activo, id_marca) 
VALUES (:nombre, :stock, :stock_minimo, :precio_compra, :precio_venta, :fecha_venc, :observaciones, :activo, :id_marca)";

$stmt = $conexion->prepare($query);

try {
    $stmt->execute([
    ":nombre" => $data["nom"] ?? null,
    ":stock" => $data["stock"] ?? 0,
    ":stock_minimo" => $data["stock_min"] ?? 0,
    ":precio_compra" => $data["prc_compra"] ?? 0,
    ":precio_venta" => $data["prc_venta"] ?? 0,
    ":fecha_venc" => $data["fch_vnc"] ?? null,
    ":observaciones" => $data["obs"] ?? "",
    ":activo" => $data["activo"] ?? 1,
    ":id_marca" => $data["id_mrc"] ?? null
]);


    echo json_encode(["mensaje" => "Producto registrado exitosamente"]);
    http_response_code(201);
} catch (Exception $e) {
    echo json_encode(["error" => "Error al registrar el producto: " . $e->getMessage()]);
    http_response_code(500);
}
?>
