<?php
header("Content-Type: application/json");
require '../controllers/conexion_bd.php';

if (!isset($conn) || mysqli_connect_errno()) {
    echo json_encode(["error" => "Error de conexión a la base de datos"]);
    http_response_code(500);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Método no permitido"]);
    http_response_code(405);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
$id_compra = $input["id_compra"] ?? null;
$productos = $input["productos"] ?? null;

if (!$id_compra || !$productos || count($productos) === 0) {
    echo json_encode(["error" => "ID de compra y productos son obligatorios"]);
    http_response_code(400);
    exit;
}

// Verificar si la compra existe
$queryCheckCompra = "SELECT id FROM compras WHERE id = ?";
$stmtCheckCompra = $conn->prepare($queryCheckCompra);
$stmtCheckCompra->bind_param("i", $id_compra);
$stmtCheckCompra->execute();
$resultCompra = $stmtCheckCompra->get_result();

if ($resultCompra->num_rows === 0) {
    echo json_encode(["error" => "Compra no encontrada"]);
    http_response_code(404);
    exit;
}
$stmtCheckCompra->close();

// Registrar los productos en `detalle_compra`
$conn->begin_transaction();

try {
    $totalCompra = 0;

    foreach ($productos as $producto) {
        $id_producto = $producto["id_producto"];
        $cantidad = $producto["cantidad"];
        $precio = $producto["precio"];
        $subtotal = $cantidad * $precio;
        $totalCompra += $subtotal;

        // Verificar que el producto existe
        $queryCheckProducto = "SELECT id FROM productos WHERE id = ?";
        $stmtCheckProducto = $conn->prepare($queryCheckProducto);
        $stmtCheckProducto->bind_param("i", $id_producto);
        $stmtCheckProducto->execute();
        $resultProducto = $stmtCheckProducto->get_result();

        if ($resultProducto->num_rows === 0) {
            throw new Exception("Error: Producto ID $id_producto no existe en la base de datos");
        }
        $stmtCheckProducto->close();

        // Insertar detalle de compra
        $queryDetalle = "INSERT INTO detalle_compra (id_compra, id_producto, cantidad, precio_compra) VALUES (?, ?, ?, ?)";
        $stmtDetalle = $conn->prepare($queryDetalle);
        $stmtDetalle->bind_param("iiid", $id_compra, $id_producto, $cantidad, $precio);
        $stmtDetalle->execute();

        if ($stmtDetalle->affected_rows === 0) {
            throw new Exception("Error al registrar el producto ID $id_producto en detalle_compra");
        }
    }

    // Actualizar el total de la compra
    $queryUpdateTotal = "UPDATE compras SET total = ? WHERE id = ?";
    $stmtTotal = $conn->prepare($queryUpdateTotal);
    $stmtTotal->bind_param("di", $totalCompra, $id_compra);
    $stmtTotal->execute();

    $conn->commit();
    echo json_encode(["success" => true, "mensaje" => "Productos registrados exitosamente"]);
    http_response_code(201);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Error al registrar los productos: " . $e->getMessage()]);
    http_response_code(500);
}
?>
