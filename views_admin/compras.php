<?php
require_once __DIR__ . '/../controllers/conexion_bd.php';

// Obtener lista de proveedores
$queryProveedores = "SELECT id, razon_social FROM proveedores WHERE activo = 1";
$resultProveedores = $conn->query($queryProveedores);

// Obtener lista de productos
$queryProductos = "SELECT id, nombre FROM productos WHERE activo = 1";
$resultProductos = $conn->query($queryProductos);
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
                <h1>Registrar Compra</h1>
            </section>

            <section class="content col-md-10 offset-md-1">
                <div id="mensajeCompra"></div>
                <form id="registroCompraForm">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Datos de la Compra</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Proveedor:</label>
                                <select class="form-control" id="ID_proveedor" name="id_proveedor" required>
                                    <option value="">Seleccione</option>
                                    <?php while ($prov = $resultProveedores->fetch_assoc()) {
                                        echo "<option value='{$prov['id']}'>{$prov['razon_social']}</option>";
                                    } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Fecha de Compra:</label>
                                <input type="date" id="fch_compra" name="fc_compra" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>IVA (%):</label>
                                <input type="number" id="IVA" name="iva" class="form-control" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sección para productos -->
                    <div class="card card-secondary">
                        <div class="card-header"><h3 class="card-title">Agregar Productos</h3></div>
                        <div class="card-body">
                            <div class="form-row align-items-end">
                                <div class="form-group col-md-5">
                                    <label>Producto:</label>
                                    <select class="form-control" id="producto">
                                        <option value="">Seleccione</option>
                                        <?php while ($prod = $resultProductos->fetch_assoc()) {
                                            echo "<option value='{$prod['id']}'>{$prod['nombre']}</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Cantidad:</label>
                                    <input type="number" id="cantidad" class="form-control" min="1">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Precio:</label>
                                    <input type="number" id="precio" class="form-control" step="0.01" min="0">
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="button" class="btn btn-success" onclick="agregarProducto()">Agregar</button>
                                </div>
                            </div>

                            <table class="table table-bordered" id="tablaDetalle">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                            <input type="hidden" name="productos" id="productosInput">
                            <h3>Total: <span id="totalCompra">0.00</span></h3>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar Compra</button>
                    </div>
                </form>
            </section>
        </div>

        <footer class="main-footer">
            <?php include_once "includes/footer.php"; ?>
        </footer>
    </div>

    <?php include_once "includes/scripts.php"; ?>

    <script>
        let productos = [];
        let total = 0;
       function eliminarProducto(btn) {
            const fila = btn.closest('tr');
            fila.remove();
        }
        function agregarProducto() {
            const productoSelect = document.getElementById('producto');
            const productoId = productoSelect.value;
            const productoNombre = productoSelect.options[productoSelect.selectedIndex].text;
            const cantidad = parseInt(document.getElementById('cantidad').value);
            const precio = parseFloat(document.getElementById('precio').value);

            if (!productoId || cantidad <= 0 || precio <= 0) {
                document.getElementById("mensajeCompra").innerHTML = `<div class="alert alert-danger">Completa correctamente los datos del producto.</div>`;
                return;
            }

            const subtotal = cantidad * precio;
            productos.push({ id_producto: productoId, cantidad, precio });

            const tabla = document.getElementById('tablaDetalle').getElementsByTagName('tbody')[0];
            const fila = tabla.insertRow();
            fila.innerHTML = `
                <td>${productoNombre}</td>
                <td>${cantidad}</td>
                <td>${precio.toFixed(2)}</td>
                <td>${subtotal.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this, ${productos.length - 1})">Eliminar</button></td>
            `;

            total += subtotal;
            document.getElementById('totalCompra').innerText = total.toFixed(2);
            document.getElementById('productosInput').value = JSON.stringify(productos);
        }

        document.getElementById("registroCompraForm").addEventListener("submit", async function(event) {
    event.preventDefault();

    try {
        const compraData = {
            id_proveedor: document.getElementById("ID_proveedor").value,
            fc_compra: document.getElementById("fch_compra").value,
            iva: parseFloat(document.getElementById("IVA").value)
        };

        let response = await fetch("registrar_compra_api.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(compraData)
        });

        let data = await response.json();
        if (data.error) throw new Error(data.error);

        const detalleData = { id_compra: data.id_compra, productos: productos };
        response = await fetch("crear_detalle_compra.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(detalleData)
        });

        data = await response.json();
        if (data.error) throw new Error(data.error);

        // Mostramos el mensaje en la página
        document.getElementById("mensajeCompra").innerHTML = `<div class="alert alert-success">Compra registrada correctamente</div>`;

        setTimeout(() => {
            document.getElementById("mensajeCompra").innerHTML = ""; // Borra el mensaje después de 5 segundos
        }, 5000);

        // Resetear formulario
        document.getElementById("registroCompraForm").reset();
        productos = [];
        document.getElementById("tablaDetalle").getElementsByTagName('tbody')[0].innerHTML = "";
        document.getElementById("totalCompra").innerText = "0.00";

    } catch (error) {
        document.getElementById("mensajeCompra").innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
    }
});
    </script>

</body>
</html>
