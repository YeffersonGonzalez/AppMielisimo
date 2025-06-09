<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../controllers/conexion_bd.php';

// Verificar conexión a la base de datos
if (!isset($conn)) {
    echo json_encode(["success" => false, "message" => "Error de conexión a la base de datos"]);
    http_response_code(500);
    exit;
}

// Verificar método de solicitud
if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
    http_response_code(405);
    exit;
}

// Obtener el ID del proveedor a eliminar
$input = json_decode(file_get_contents("php://input"), true);
$id = $input['id'] ?? $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    echo json_encode(["success" => false, "message" => "ID del proveedor no especificado o inválido"]);
    http_response_code(400);
    exit;
}

// Verificar si el proveedor existe antes de eliminarlo
$checkStmt = $conn->prepare("SELECT id FROM proveedores WHERE id = ?");
$checkStmt->bind_param("i", $id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Proveedor no encontrado"]);
    http_response_code(404);
    exit;
}
$checkStmt->close();

// Ejecutar la eliminación del proveedor
$deleteStmt = $conn->prepare("DELETE FROM proveedores WHERE id = ?");
if (!$deleteStmt) {
    echo json_encode(["success" => false, "message" => "Error al preparar la consulta: " . $conn->error]);
    http_response_code(500);
    exit;
}

$deleteStmt->bind_param("i", $id);
if ($deleteStmt->execute()) {
    echo json_encode(["mensaje" => "Producto eliminado correctamente"]);
    http_response_code(200);
} else {
    echo json_encode(["error" => "Error al eliminar el producto: " . $e->getMessage()]);
    http_response_code(500);
}

$deleteStmt->close();
$conn->close();
?>
