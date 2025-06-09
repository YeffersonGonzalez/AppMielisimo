<?php
header("Content-Type: application/json");
require '../controllers/conexion_bd.php';

if (!isset($conn) || mysqli_connect_errno()) {
    echo json_encode(["error" => "Error de conexión a la base de datos: " . mysqli_connect_error()]);
    http_response_code(500);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Método no permitido"]);
    http_response_code(405);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);

if (!$input || json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Error en el JSON recibido"]);
    http_response_code(400);
    exit;
}

$id_proveedor = $input["id_proveedor"] ?? null;
$fc_compra = $input["fc_compra"] ?? null;
$iva = $input["iva"] ?? null;
$id_usuario = 1; // Ajusta esto según el usuario activo

if (!$id_proveedor || !$fc_compra || !$iva) {
    echo json_encode(["error" => "Todos los campos son obligatorios"]);
    http_response_code(400);
    exit;
}

// Generar código único
$codigo = "CMP" . date("Ymd") . rand(100, 999);

$conn->begin_transaction();

try {
    $queryCompra = "INSERT INTO compras (codigo, fc_compra, iva, id_usuario, id_proveedor, total) VALUES (?, ?, ?, ?, ?, 0)";
    $stmtCompra = $conn->prepare($queryCompra);
    $stmtCompra->bind_param("ssdid", $codigo, $fc_compra, $iva, $id_usuario, $id_proveedor);

    if (!$stmtCompra->execute()) {
        throw new Exception("Error en la inserción: " . mysqli_error($conn));
    }

    $id_compra = $stmtCompra->insert_id;

    if ($id_compra === 0) {
        throw new Exception("Error: ID de compra no generado");
    }

    $conn->commit();

    echo json_encode(["success" => true, "mensaje" => "Compra registrada exitosamente", "id_compra" => $id_compra, "codigo" => $codigo]);
    http_response_code(201);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Error en la API: " . $e->getMessage()]);
    http_response_code(500);
}
?>
