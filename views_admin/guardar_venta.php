<?php
header("Content-Type: application/json");
require '../controllers/conexion_bd.php';

// Verificar método HTTP
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Método no permitido"]);
    http_response_code(405);
    exit;
}

// Leer y validar JSON
$rawInput = file_get_contents("php://input");
$input = json_decode($rawInput, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Error en el formato JSON recibido"]);
    http_response_code(400);
    exit;
}

$fc_venta = $input["fc_venta"] ?? null;
$iva = $input["iva"] ?? null;
$id_usuario = 1; // Ajusta según el usuario activo
$productos = $input["productos"] ?? [];

if (!$fc_venta || !$iva || empty($productos)) {
    echo json_encode(["error" => "Fecha de venta, IVA y productos son obligatorios"]);
    http_response_code(400);
    exit;
}

// Generar código único
$codigo = "VNT" . date("Ymd") . rand(100, 999);
$totalVenta = array_reduce($productos, function ($sum, $prod) {
    return $sum + ($prod["cantidad"] * $prod["precio"]);
}, 0);

// Insertar venta con los productos en JSON
$queryVenta = "INSERT INTO ventas (codigo, fc_venta, id_usuario, iva, total, productos) VALUES (?, ?, ?, ?, ?, ?)";
$stmtVenta = $conn->prepare($queryVenta);
$jsonProductos = json_encode($productos);
$stmtVenta->bind_param("ssidds", $codigo, $fc_venta, $id_usuario, $iva, $totalVenta, $jsonProductos);

if (!$stmtVenta->execute()) {
    echo json_encode(["error" => "Error al registrar la venta"]);
    http_response_code(500);
    exit;
}

echo json_encode(["success" => true, "mensaje" => "Venta registrada correctamente", "id_venta" => $stmtVenta->insert_id]);
http_response_code(201);
?>
