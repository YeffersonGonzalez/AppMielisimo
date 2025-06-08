<?php
require_once __DIR__ . '/../models/models_admin.php';

$db = new DBConfig();
$db->config();
$db->conexion();
$queryMarcas = "SELECT id, nombre FROM marcas";
$stmtMarcas = $db->db_link->prepare($queryMarcas);
$stmtMarcas->execute();
$marcas = $stmtMarcas->fetchAll(PDO::FETCH_ASSOC);
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Error: ID del producto no especificado.");
}

// Obtener producto
$query = "SELECT * FROM productos WHERE id = :id";
$stmt = $db->db_link->prepare($query);
$stmt->execute([":id" => $id]);
$producto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$producto) {
    die("Error: Producto no encontrado.");
}

// Procesar actualización
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $stock = $_POST["stock"];
    $stock_minimo = $_POST["stock_minimo"];
    $precio_compra = $_POST["precio_compra"];
    $precio_venta = $_POST["precio_venta"];
    $fecha_venc = $_POST["fecha_venc"];
    $observaciones = $_POST["observaciones"];
    $activo = isset($_POST["activo"]) ? 1 : 0;
    $id_marca = $_POST["id_marca"];

    $updateQuery = "UPDATE productos SET nombre=:nombre, stock=:stock, stock_minimo=:stock_minimo,
                    precio_compra=:precio_compra, precio_venta=:precio_venta, fecha_venc=:fecha_venc,
                    observaciones=:observaciones, activo=:activo, id_marca=:id_marca WHERE id=:id";

    $stmtUpdate = $db->db_link->prepare($updateQuery);

    try {
        $stmtUpdate->execute([
            ":nombre" => $nombre,
            ":stock" => $stock,
            ":stock_minimo" => $stock_minimo,
            ":precio_compra" => $precio_compra,
            ":precio_venta" => $precio_venta,
            ":fecha_venc" => $fecha_venc,
            ":observaciones" => $observaciones,
            ":activo" => $activo,
            ":id_marca" => $id_marca,
            ":id" => $id
        ]);
        $mensaje = "Producto actualizado exitosamente.";
    } catch (Exception $e) {
        $mensaje = "Error al actualizar el producto: " . $e->getMessage();
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
                            <h1>Editar Producto</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content-body">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header bg-indigo">
                                <h3 class="card-title">Editar Producto</h3>
                            </div>

                            <?php if (!empty($mensaje)): ?>
                                <div class="alert alert-info"><?php echo $mensaje; ?></div>
                            <?php endif; ?>

                            <form method="POST">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Nombre</label>
                                            <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Stock</label>
                                            <input type="number" class="form-control" name="stock" value="<?php echo $producto['stock']; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Stock mínimo</label>
                                            <input type="number" class="form-control" name="stock_minimo" value="<?php echo $producto['stock_minimo']; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Precio compra</label>
                                            <input type="number" class="form-control" name="precio_compra" value="<?php echo $producto['precio_compra']; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Precio venta</label>
                                            <input type="number" class="form-control" name="precio_venta" value="<?php echo $producto['precio_venta']; ?>">
                                        </div>
                                        <div class="col-md-6">
                                          <label>Marca</label>
                                          <select class="form-control" name="id_marca">
                                              <?php foreach ($marcas as $marca): ?>
                                                  <option value="<?php echo $marca['id']; ?>" 
                                                      <?php echo ($producto['id_marca'] == $marca['id']) ? 'selected' : ''; ?>>
                                                      <?php echo htmlspecialchars($marca['nombre']); ?>
                                                  </option>
                                              <?php endforeach; ?>
                                          </select>
                                      </div>
                                        <div class="col-md-6">
                                            <label>Fecha vencimiento</label>
                                            <input type="date" class="form-control" name="fecha_venc" value="<?php echo $producto['fecha_venc']; ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Observaciones</label>
                                            <textarea class="form-control" name="observaciones"><?php echo $producto['observaciones']; ?></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="checkbox" name="activo" value="1" <?php echo $producto['activo'] ? 'checked' : ''; ?>> Activo
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                                    <a href="lista_productos.php" class="btn btn-warning">Regresar</a>
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
