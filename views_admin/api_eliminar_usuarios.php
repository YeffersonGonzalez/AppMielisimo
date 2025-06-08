<?php

header("Content-Type: application/json");
require '../controllers/conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($input['id'])) {
        $id = intval($input['id']);
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        if (!$stmt) {
            echo json_encode(["success" => false, "message" => "Error al preparar la consulta: " . $conn->error]);
            exit;
        }
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "id" => $id]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al eliminar al usuario, Hay citas pendientes."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "ID no proporcionado."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}

$conn->close();
?>
