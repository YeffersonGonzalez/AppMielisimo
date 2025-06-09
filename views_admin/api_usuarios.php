<?php
header("Content-Type: application/json");
require '../controllers/conexion_bd.php';

// Obtener los parámetros de la consulta
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5; // Número de usuarios por página
$offset = ($page - 1) * $limit; // Calcular el desplazamiento

// Contar el total de usuarios para la paginación
$totalSql = "SELECT COUNT(*) as total FROM usuarios";
$totalResult = $conn->query($totalSql);
if (!$totalResult) {
    echo json_encode(['error' => 'Error en la consulta de conteo']);
    exit;
}
$totalRow = $totalResult->fetch_assoc();
$totalusuarios = $totalRow['total'];

// Modificar la consulta para obtener solo los usuarios de la página actual
$sql = "SELECT * FROM usuarios 
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar la consulta']);
    exit;
}

// Usar bind_param para evitar inyección SQL
$stmt->bind_param('ii', $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
$usuarios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

// Crear el objeto de respuesta
$response = [
    'total' => $totalusuarios,
    'usuarios' => $usuarios,
    'page' => $page,
    'limit' => $limit
];

echo json_encode($response);
$stmt->close();
$conn->close();
?>
