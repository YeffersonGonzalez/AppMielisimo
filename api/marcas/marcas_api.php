<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../models/models_admin.php';

$db = new DBConfig();
$db->config();
$db->conexion();

// Obtener el ID de la marca desde la URL
$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(["error" => "ID de marca no especificado"]);
    http_response_code(400);
    exit;
}

// Usamos la función `buscarMarcasPorNombre($id)` para obtener la marca por su ID
$marca = $db->buscarMarcasPorID($id);

// Si no se encuentra la marca, enviamos un error
if (!$marca) {
    echo json_encode(["error" => "Marca no encontrada"]);
    http_response_code(404);
    exit;
}

// Enviar los datos de la marca en formato JSON
echo json_encode($marca);
http_response_code(200);
?>
