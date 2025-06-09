<?php
header('Content-Type: application/json');
require '../controllers/conexion_bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    // Verifica si el JSON fue decodificado correctamente
    if (!$data) {
        echo json_encode(["error" => "Error en la decodificación del JSON o JSON vacío"]);
        exit;
    }

    // Verifica que todos los datos requeridos están presentes
    if (!isset($data['nombre']) || !isset($data['tipo'])) {
        echo json_encode(["error" => "Faltan datos requeridos."]);
        exit;
    }

    // Asignación de variables
    $nombre = $data['nombre'];
    $tipo = $data['tipo'];
    $password = isset($data['password']) ? $data['password'] : null;

    if (empty($password)) {
        echo json_encode(["error" => "La contraseña es requerida."]);
        exit;
    }
    
    // Hashear la contraseña usando bcrypt
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Lógica para asignar el rol según el tipo de usuario
    $rol = null;
    if ($tipo === '1') {
        $rol = 1;  // Asignar rol 1 para barbero
    } else {
        $rol = 2;  // Asignar rol 3 para cliente
        
    }

    // Prepara la consulta SQL para insertar el nuevo usuario con el rol
    $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password, id_rol ) VALUES (?, ?, ?)");
    
    if (!$stmt) {
        echo json_encode(["error" => "Error al preparar la consulta: " . $conn->error]);
        exit;
    }

    // Vincula los parámetros a la consulta preparada
    $stmt->bind_param("ssi", $nombre,$hashed_password, $rol, );

    // Ejecuta la consulta y verifica si se insertó correctamente
    if ($stmt->execute()) {
        echo json_encode(["success" => "Usuario registrado exitosamente."]);
    } else {
        echo json_encode(["error" => "Error al ejecutar la consulta: " . $stmt->error]);
    }

    // Cierra la declaración y la conexión
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Método no permitido."]);
}
