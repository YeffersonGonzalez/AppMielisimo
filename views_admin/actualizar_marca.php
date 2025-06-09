<?php
require_once __DIR__ . '/../models/models_admin.php';
require '../controllers/conexion_bd.php';
$db = new DBConfig();
$db->config();
$db->conexion();

// Obtener marcas para el formulario de selección
$queryMarcas = "SELECT * FROM marcas";
$stmtMarcas = $db->db_link->prepare($queryMarcas);
$stmtMarcas->execute();
$marcas = $stmtMarcas->fetchAll(PDO::FETCH_ASSOC);

// Obtener ID de la marca a editar
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Error: ID de marca no especificado.");
}

// Obtener datos de la marca seleccionada
$query = "SELECT * FROM marcas WHERE id = :id";
$stmt = $db->db_link->prepare($query);
$stmt->execute([":id" => $id]);
$marca = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$marca) {
    die("Error: Marca no encontrada.");
}

// Procesar actualización
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $activo = isset($_POST["activo"]) ? 1 : 0;

    $updateQuery = "UPDATE marcas SET nombre=:nombre, activo=:activo WHERE id=:id";
    $stmtUpdate = $db->db_link->prepare($updateQuery);

    try {
        $stmtUpdate->execute([
            ":nombre" => $nombre,
            ":activo" => $activo,
            ":id" => $id
        ]);
        $mensaje = "Marca actualizada exitosamente.";
    } catch (Exception $e) {
        $mensaje = "Error al actualizar la marca: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include_once "includes/head.php"; ?>
</head>
<body class="sidebar-collapse sidebar-mini">
    <?php include_once "includes/config.php"; ?>

    <div class="wrapper">
        <nav class="main-header navbar navbar-expand <?php echo $headerStyle; ?>">
            <?php include_once "includes/header.php"; ?>
        </nav>

        <aside class="main-sidebar <?php echo $lateralStyle; ?> elevation-4">
            <?php include_once "includes/lateralaside.php"; ?>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Editar Marca</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content-body">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card">
                            <div class="card-header bg-indigo">
                                <h3 class="card-title">Editar Marca</h3>
                            </div>

                            <?php if (!empty($mensaje)): ?>
                                <div class="alert alert-info"><?php echo $mensaje; ?></div>
                            <?php endif; ?>

                            <form method="POST">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nombre de la marca</label>
                                        <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($marca['nombre']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <select class="form-control" name="activo">
                                            <option value="1" <?php echo ($marca['activo'] == 1) ? 'selected' : ''; ?>>Activo</option>
                                            <option value="0" <?php echo ($marca['activo'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                                    <a href="lista_marcas.php" class="btn btn-warning">Regresar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <?php include_once "includes/footer.php"; ?>
        </footer>
    </div>
</body>
</html>
