<?php
require_once __DIR__ . '/../controllers/conexion_bd.php';

// Si se pasa un ID de venta para eliminar
if (isset($_GET['delete'])) {
    $idVenta = intval($_GET['delete']);
    $queryEliminar = "DELETE FROM ventas WHERE id = ?";
    $stmt = $conn->prepare($queryEliminar);
    $stmt->bind_param("i", $idVenta);

    if ($stmt->execute()) {
        echo "<script>Swal.fire('Venta eliminada', 'La venta ha sido eliminada correctamente.', 'success');</script>";
    } else {
        echo "<script>Swal.fire('Error', 'No se pudo eliminar la venta.', 'error');</script>";
    }

}

// Obtener lista de productos
$queryProductos = "SELECT * FROM productos";
$resultProductos = $conn->query($queryProductos);
$productos = [];

while ($producto = $resultProductos->fetch_assoc()) {
    $productos[$producto['id']] = $producto['nombre'];
}

// Obtener lista de ventas
$queryVentas = "SELECT id, codigo, fc_venta, id_usuario, iva, total, JSON_UNQUOTE(JSON_EXTRACT(productos, '$')) AS detalles FROM ventas ORDER BY fc_venta DESC";
$resultVentas = $conn->query($queryVentas);


?>

<!DOCTYPE html>
<html>
<head>
    <?php include_once "includes/head.php"; ?>
</head>
<body class="sidebar-collapse sidebar-mini">
    <?php include_once "includes/config.php"; ?>

    <div class="wrapper">
      <script>
        
      
      </script>
        <nav class="main-header navbar navbar-expand <?php echo $headerStyle; ?>">
            <?php include_once "includes/header.php"; ?>
        </nav>

        <aside class="main-sidebar <?php echo $lateralStyle; ?> elevation-4">
            <?php include_once "includes/lateralaside.php"; ?>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>Ventas Registradas</h1>
            </section>

            <section class="content">
                <div id="mensajeVenta"></div>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Ventas</h3>
                    </div>
                    <div class="card-body">
                        <table id="tablaVentas" class="table table-bordered table-striped">
                            <thead>
                          <tr>
                              <th>Código</th>
                              <th>Fecha</th>
                              <th>Total</th>
                              <th>IVA</th>
                              <th>Usuario</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php while ($venta = $resultVentas->fetch_assoc()): ?>
                              <tr>
                                  <td><?= $venta['codigo'] ?></td>
                                  <td><?= $venta['fc_venta'] ?></td>
                                  <td><?= number_format($venta['total'], 2) ?></td>
                                  <td><?= number_format($venta['iva'], 2) ?>%</td>
                                  <td><?= $venta['id_usuario'] ?></td>
                                  <td>
                                      <button class="btn btn-info btn-sm" onclick='verDetallesVenta(<?= json_encode($venta["detalles"]) ?>)'>Ver Detalles</button>
                                      <button class="btn btn-danger btn-sm" onclick="confirmarEliminacion(<?= $venta['id'] ?>)">Eliminar Venta</button>
                                  </td>
                              </tr>
                          <?php endwhile; ?>
                      </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <?php include_once "includes/footer.php"; ?>
        </footer>
    </div>

    <!-- Modal para ver detalles de la venta -->
    <div class="modal fade" id="modalDetalleVenta" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles de Venta</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDetalleVenta">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include_once "includes/scripts.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
        function verDetallesVenta(jsonDetalles) {
            const detalles = JSON.parse(jsonDetalles);
            let mensaje = "<strong>Detalles de Venta</strong><br><br>";

            detalles.forEach((producto) => {
               
                mensaje += `<strong>Producto:</strong> ${producto.id_producto}<br>`;
                mensaje += `<strong>Cantidad:</strong> ${producto.cantidad}<br>`;
                mensaje += `<strong>Precio:</strong> $${producto.precio.toFixed(2)}<br>`;
                mensaje += `<strong>Subtotal:</strong> $${(producto.cantidad * producto.precio).toFixed(2)}<hr>`;
            });

            Swal.fire({
                title: "Detalles de Venta",
                html: mensaje,
                icon: "info",
                confirmButtonText: "Cerrar"
            });
        }

        function confirmarEliminacion(idVenta) {
            Swal.fire({
                title: "¿Eliminar esta venta?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "?delete=" + idVenta;
                }
            });
        }
    </script>
</body>
</html>
