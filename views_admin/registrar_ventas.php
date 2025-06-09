<?php
require_once __DIR__ . '/../controllers/conexion_bd.php';

// Obtener lista de productos desde la base de datos
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
                <h1>Registrar Venta</h1>
            </section>

            <section class="content">
                <div id="mensajeVenta"></div>
                
                <form id="registroVentaForm">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Datos de la Venta</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Fecha de Venta:</label>
                                <input type="date" id="fc_venta" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>IVA (%):</label>
                                <input type="number" id="IVA" class="form-control" step="0.01" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="card card-secondary">
                        <div class="card-header"><h3 class="card-title">Agregar Productos</h3></div>
                        <div class="card-body">
                            <div class="form-row align-items-end">
                                <div class="form-group col-md-5">
                                    <label>Producto:</label>
                                    <select class="form-control" id="producto">
                                        <option value="">Seleccione</option>
                                        <?php while ($prod = $resultProductos->fetch_assoc()): ?>
                                            <option value="<?= $prod['id'] ?>"><?= $prod['nombre'] ?></option>
                                        <?php endwhile; ?>
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
                                    <button type="button" class="btn btn-success" id="btnAgregar">Agregar</button>
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

                            <input type="hidden" id="productosInput">
                            <h3>Total: <span id="totalVenta">0.00</span></h3>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Registrar Venta</button>
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

document.getElementById("btnAgregar").addEventListener("click", function() {
    const productoSelect = document.getElementById('producto');
    const productoId = productoSelect.value;
    const productoNombre = productoSelect.options[productoSelect.selectedIndex].text;
    const cantidad = parseInt(document.getElementById('cantidad').value);
    const precio = parseFloat(document.getElementById('precio').value);

    if (!productoId || cantidad <= 0 || precio <= 0) {
        document.getElementById("mensajeVenta").innerHTML = `<div class="alert alert-danger">Complete los datos correctamente.</div>`;
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
        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this)">Eliminar</button></td>
    `;

    total += subtotal;
    document.getElementById('totalVenta').innerText = total.toFixed(2);
    document.getElementById('productosInput').value = JSON.stringify(productos);
});

function eliminarProducto(btn) {
    const fila = btn.closest('tr');
    fila.remove();
}

document.getElementById("registroVentaForm").addEventListener("submit", async function(event) {
    event.preventDefault();

    try {
        if (!productos || productos.length === 0) {
            throw new Error("Debe agregar al menos un producto antes de registrar la venta.");
        }

        const ventaData = {
            fc_venta: document.getElementById("fc_venta").value,
            iva: parseFloat(document.getElementById("IVA").value),
            productos: productos
        };

        let response = await fetch("guardar_venta.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(ventaData)
        });

        let textResponse = await response.text();
        let data;
        try {
            data = JSON.parse(textResponse);
        } catch (error) {
            throw new Error("Respuesta inesperada de la API. Verifica que `guardar_venta.php` devuelve JSON.");
        }

        if (!response.ok) throw new Error(data.error || "Error desconocido al registrar la venta.");

        // Mostrar mensaje de éxito y resetear formulario después de 5 segundos
        document.getElementById("mensajeVenta").innerHTML = `<div class="alert alert-success">${data.mensaje}</div>`;
        setTimeout(() => {
            document.getElementById("mensajeVenta").innerHTML = "";
            document.getElementById("registroVentaForm").reset();
            productos = [];
            document.getElementById("tablaDetalle").getElementsByTagName('tbody')[0].innerHTML = "";
            document.getElementById("totalVenta").innerText = "0.00";
        }, 5000);

    } catch (error) {
        document.getElementById("mensajeVenta").innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
        setTimeout(() => {
            document.getElementById("mensajeVenta").innerHTML = "";
        }, 5000);
    }
});


    </script>
</body>
</html>
