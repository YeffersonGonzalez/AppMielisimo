<?php
require_once __DIR__ . '/../models/models_admin.php';

$db = new DBConfig();
$db->config();
$db->conexion();
$marcas = $db->getMarcas();
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
                            <h1>Registro de inventario</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content-body">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card">
                            <div class="card-header bg-indigo">
                                <h3 class="card-title">Productos</h3>
                            </div>

                            <form id="form_productos">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="txtCodigo">Código</label>
                                            <input type="text" class="form-control" name="codigo">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="txtNombre">Nombre</label>
                                            <input type="text" class="form-control" name="nom">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="txtStock">Stock</label>
                                            <input type="number" class="form-control" name="stock">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="txtStock_min">Stock mínimo</label>
                                            <input type="number" class="form-control" name="stock_min">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="txtPrecio_C">Precio compra</label>
                                            <input type="number" step="0.01" class="form-control" name="prc_compra">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="txtPrecio_V">Precio venta</label>
                                            <input type="number" step="0.01" class="form-control" name="prc_venta">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="txtMarca">Marca</label>
                                            <select class="form-control" name="id_mrc" id="selectMarca">
                                                <?php foreach ($marcas as $marca): ?>
                                                    <option value="<?php echo htmlspecialchars($marca['id']); ?>">
                                                        <?php echo htmlspecialchars($marca['nombre']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="txtFe">Fecha vencimiento</label>
                                            <input type="date" class="form-control" name="fch_vnc">
                                        </div>
                                        <div class="col-md-12">
                                            <label>Observación</label>
                                            <textarea class="form-control" rows="3" name="obs"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="activo" value="1" checked>
                                                <label class="form-check-label">Producto activo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="button" id="btnEnviar" class="btn btn-success">Enviar</button>
                                    <button type="reset" class="btn btn-default">Limpiar</button>
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

    <?php include_once "includes/scripts.php"; ?>
    <script>
        document.getElementById("btnEnviar").addEventListener("click", function() {
            const formData = new FormData(document.getElementById("form_productos"));
            const jsonData = Object.fromEntries(formData.entries());

            fetch("http://localhost/AppMielisimo/api/productos/productos_api_create.php", { // Ruta corregida
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(jsonData)
            })
            .then(response => response.json())
            .then(data => alert(data.mensaje || data.error))
            .catch(error => {
                alert("Error al registrar el producto.");
                console.error(error);
            });
        });
    </script>
</body>

</html>
