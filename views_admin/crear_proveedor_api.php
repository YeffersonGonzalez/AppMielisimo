<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../models/models_admin.php';

$db = new DBConfig();
$db->config();
$db->conexion();

// Verificar método de solicitud
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["error" => "Método no permitido"]);
    http_response_code(405);
    exit;
}

// Capturar los datos en JSON
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Validar datos recibidos
if (!$data || !isset($data["RazonSocial"]) || !isset($data["Telefono"]) || !isset($data["email"]) || !isset($data["direccion"])) {
    echo json_encode(["error" => "Todos los campos son obligatorios"]);
    http_response_code(400);
    exit;
}

// Preparar consulta para insertar proveedor en la base de datos
$query = "INSERT INTO proveedores (razon_social, telefono, email, direccion, activo) 
          VALUES (:razon_social, :telefono, :email, :direccion, :activo)";
$stmt = $db->db_link->prepare($query);

try {
    $stmt->execute([
        ":razon_social" => $data["RazonSocial"],
        ":telefono" => $data["Telefono"],
        ":email" => $data["email"],
        ":direccion" => $data["direccion"],
        ":activo" => isset($data["activo"]) ? 1 : 0
    ]);

    echo json_encode(["mensaje" => "Proveedor registrado exitosamente"]);
    http_response_code(201);
} catch (Exception $e) {
    echo json_encode(["error" => "Error al registrar proveedor: " . $e->getMessage()]);
    http_response_code(500);
}
?>
