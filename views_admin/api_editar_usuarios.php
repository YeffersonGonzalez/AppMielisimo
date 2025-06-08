<?php
header("Content-Type: application/json");
require '../controllers/conexion_bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id']) || !isset($data['nombre'])) {
        echo json_encode(["success" => false, "message" => "Faltan datos requeridos."]);
        exit;
    }

    $id = $data['id'];
    $nombre = $data['nombre'];
   

    $sql = "UPDATE usuarios SET usuario = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Error al preparar la consulta: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("si", $nombre, $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Usuario actualizado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar el usuario."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>
