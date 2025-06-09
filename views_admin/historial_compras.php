<?php
require_once __DIR__ . '/../controllers/conexion_bd.php';

// Capturar fechas del filtro
$fechaInicio = $_GET['fecha_inicio'] ?? null;
$fechaFin = $_GET['fecha_fin'] ?? null;

// Construir consulta con filtro de fecha si es necesario
$queryHistorial = "SELECT 
    c.id AS compra_id,
    c.fc_compra AS fecha,
    p.razon_social AS proveedor,
    pr.nombre AS producto,
    dc.cantidad,
    dc.precio_compra AS precio_unitario,
    (dc.cantidad * dc.precio_compra) AS subtotal
FROM compras c
JOIN detalle_compra dc ON c.id = dc.id_compra
JOIN proveedores p ON c.id_proveedor = p.id
JOIN productos pr ON dc.id_producto = pr.id";

if ($fechaInicio && $fechaFin) {
    $queryHistorial .= " WHERE c.fc_compra BETWEEN '$fechaInicio' AND '$fechaFin'";
}

$queryHistorial .= " ORDER BY c.fc_compra DESC";

$resultado = $conn->query($queryHistorial);
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
                <h1>Historial de Compras</h1>
            </section>

            <section class="content">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Historial de Compras</h3>
                    </div>
                    <div class="card-body">
                        <!-- Filtro de Fecha -->
                        <form id="filtroFechaForm">
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label>Desde:</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                                </div>
                                <div class="form-group col-md-5">
                                    <label>Hasta:</label>
                                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
                                </div>
                                <div class="form-group col-md-2 align-self-end">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                </div>
                            </div>
                        </form>

                        <!-- Tabla Historial de Compras -->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Compra</th>
                                    <th>Fecha</th>
                                    <th>Proveedor</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['compra_id'] ?></td>
                                    <td><?= $row['fecha'] ?></td>
                                    <td><?= $row['proveedor'] ?></td>
                                    <td><?= $row['producto'] ?></td>
                                    <td><?= $row['cantidad'] ?></td>
                                    <td><?= number_format($row['precio_unitario'], 2) ?></td>
                                    <td><?= number_format($row['subtotal'], 2) ?></td>
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

    <?php include_once "includes/scripts.php"; ?>

    <script>
        document.getElementById("filtroFechaForm").addEventListener("submit", function(event) {
            event.preventDefault();

            const fechaInicio = document.getElementById("fecha_inicio").value;
            const fechaFin = document.getElementById("fecha_fin").value;

            if (!fechaInicio || !fechaFin) {
                alert("Seleccione un rango de fechas válido.");
                return;
            }

            window.location.href = `historial_compras.php?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`;
        });
    </script>
</body>
</html>
