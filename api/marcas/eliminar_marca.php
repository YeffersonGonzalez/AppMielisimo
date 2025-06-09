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
if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    echo json_encode(["error" => "Método no permitido"]);
    http_response_code(405);
    exit;
}

// Obtener ID de la marca
$id = $_GET["id"] ?? null;

if (!$id) {
    echo json_encode(["error" => "ID no especificado"]);
    http_response_code(400);
    exit;
}

// Eliminar marca de la base de datos
$query = "DELETE FROM marcas WHERE id = :id";
$stmt = $conexion->prepare($query);

try {
    $stmt->execute([":id" => $id]);
    echo json_encode(["mensaje" => "Marca eliminada correctamente"]);
    http_response_code(200);
} catch (Exception $e) {
    echo json_encode(["error" => "Error al eliminar la marca: " . $e->getMessage()]);
    http_response_code(500);
}
?>
