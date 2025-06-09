<?php
header("Content-Type: application/json");
require '../controllers/conexion_bd.php';

// Verificar método HTTP
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Método no permitido"]);
    http_response_code(405);
    exit;
}

// Leer datos JSON
$rawInput = file_get_contents("php://input");
$input = json_decode($rawInput, true);

// Validar JSON recibido
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "Error en el formato JSON recibido"]);
    http_response_code(400);
    exit;
}

$id_venta = $input["id_venta"] ?? null;
$productos = $input["productos"] ?? [];

if (!$id_venta || empty($productos)) {
    echo json_encode(["error" => "ID de venta y productos son obligatorios"]);
    http_response_code(400);
    exit;
}

// Verificar conexión a la base de datos
if (!isset($conn) || mysqli_connect_errno()) {
    echo json_encode(["error" => "Error de conexión a la base de datos"]);
    http_response_code(500);
    exit;
}

// Iniciar transacción
$conn->begin_transaction();
$totalVenta = 0;

try {
    foreach ($productos as $producto) {
        if (!isset($producto["producto_id"], $producto["cantidad"], $producto["precio"])) {
            throw new Exception("Datos de producto incompletos: " . json_encode($producto));
        }

        $id_producto = $producto["producto_id"];
        $cantidad = $producto["cantidad"];
        $precio = $producto["precio"];
        $subtotal = $cantidad * $precio;
        $totalVenta += $subtotal;

        // Insertar detalle de venta
        $queryDetalle = "INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_venta) VALUES (?, ?, ?, ?)";
        $stmtDetalle = $conn->prepare($queryDetalle);
        $stmtDetalle->bind_param("iiid", $id_venta, $id_producto, $cantidad, $precio);

        if (!$stmtDetalle->execute()) {
            throw new Exception("Error en la inserción del detalle: " . $stmtDetalle->error);
        }
    }

    // Actualizar total en ventas
    $queryTotal = "UPDATE ventas SET total = ? WHERE id = ?";
    $stmtTotal = $conn->prepare($queryTotal);
    $stmtTotal->bind_param("di", $totalVenta, $id_venta);

    if (!$stmtTotal->execute()) {
        throw new Exception("Error al actualizar el total de venta: " . $stmtTotal->error);
    }

    $conn->commit();
    echo json_encode(["success" => true, "mensaje" => "Detalle de venta registrado correctamente"]);
    http_response_code(201);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Error en el detalle de venta: " . $e->getMessage()]);
    http_response_code(500);
}
?>
