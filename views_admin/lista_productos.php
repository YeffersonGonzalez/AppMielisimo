<?php
require_once __DIR__ . '/../models/models_admin.php';

try {
    $db = new DBConfig();
    $db->config();
    $db->conexion();

    $productos = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["txtBuscar"])) {
        $productos = $db->buscarProductosPorNombre($_POST["txtBuscar"]); // Filtrar por nombre
    } else {
        $productos = $db->getProductos(); // Obtener todos los productos
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
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
                            <h1>Productos registrados</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="card-body">
                    <!-- Formulario de búsqueda -->
                    <form method="POST" class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="txtBuscar" class="form-control" placeholder="Buscar producto por nombre...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered table-hover" id="tabla_productos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Fecha Vencimiento</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($productos && count($productos) > 0): ?>
                                <?php foreach ($productos as $producto): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($producto['id']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['observaciones']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['precio_compra']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['precio_venta']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['fecha_venc']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                                        <td><?php echo htmlspecialchars($producto['activo'] ? 'Activo' : 'Inactivo'); ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm btn-editar" data-id="<?php echo $producto['id']; ?>">Editar</button>
                                            <button class="btn btn-danger btn-sm btn-eliminar" data-id="<?php echo $producto['id']; ?>">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9">No hay productos registrados</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <?php include_once "includes/footer.php"; ?>
        </footer>
    </div>

    <?php include_once "includes/scripts.php"; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Acción de eliminar producto
            document.querySelectorAll(".btn-eliminar").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
                        fetch(`delete_producto.php?id=${id}`, {
                            method: "DELETE"
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.mensaje || data.error);
                            location.reload();
                        })
                        .catch(error => console.error("Error:", error));
                    }
                });
            });

            // Acción de editar producto
            document.querySelectorAll(".btn-editar").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    window.location.href = `actualizar_productos.php?id=${id}`;
                });
            });
        });

        document.getElementById("btnBuscar").addEventListener("click", function() {
                filtrarProductos();
            });

            function filtrarProductos() {
                let input = document.getElementById("searchBox").value.toLowerCase();
                let filas = document.querySelectorAll("#productosBody tr");

                filas.forEach(fila => {
                    let textoFila = fila.innerText.toLowerCase();
                    fila.style.display = textoFila.includes(input) ? "" : "none";
                });
            }


    </script>
</body>

</html>
