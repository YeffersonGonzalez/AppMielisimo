<!DOCTYPE html>
<html>

<head>
  <?php include_once "includes/head.php"; ?>
</head>

<body class="sidebar-collapse sidebar-mini">

  <?php include_once "includes/config.php"; ?>

  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand <?php echo $headerStyle; ?>">
      <?php
      include_once "includes/header.php";
      ?>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar <?php echo $lateralStyle; ?> elevation-4">
      <?php
      include_once "includes/lateralaside.php";
      ?>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Titulo Página</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">titulo Corto</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

      

<!-- Contenido principal -->
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Registrar Compra</h1>
    </div>
  </section>

  <section class="content">
    <form action="procesar_compra.php" method="POST">
      <div class="card card-primary">
        <div class="card-header"><h3 class="card-title">Datos de la Compra</h3></div>
        <div class="card-body">
          <div class="form-group">
            <label>Proveedor:</label>
            <select class="form-control select2" id="ID_proveedor" name="id_proveedor" required>
              <option value="">Seleccione</option>
              <?php /*
              $proveedores = mysqli_query($conn, "SELECT id, nombre FROM proveedores WHERE activo = 1");
              while ($prov = mysqli_fetch_assoc($proveedores)) {
                echo "<option value='{$prov['id']}'>{$prov['nombre']}</option>";
              }
             */ ?>
            </select>
          </div>

          <div class="form-group">
            <label>Fecha de Compra:</label>
            <input type="date" id="fch_compra" name="fc_compra" class="form-control" required>
          </div>

          <div class="form-group">
            <label>IVA (%):</label>
            <input type="number" id="IVA"  name="iva" class="form-control" step="0.01" min="0" required>
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
              <select class="form-control select2" id="producto">
                <option value="">Seleccione</option>
                <?php /*
                $productos = mysqli_query($conn, "SELECT id, nombre FROM productos WHERE activo = 1");
                while ($prod = mysqli_fetch_assoc($productos)) {
                  echo "<option value='{$prod['id']}'>{$prod['nombre']}</option>";
                }
                */?>
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
              <button type="button" id="BtnAgregar" class="btn btn-success" onclick="agregarProducto()">Agregar</button>
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
        </div>
      </div>

      <div class="card-footer">
        <button type="submit" id="registarCmp" class="btn btn-primary">Registrar Compra</button>
      </div>
    </form>
  </section>
</div>


<!-- Script para agregar productos 
<script>
  let productos = [];

  function agregarProducto() {
    const productoSelect = document.getElementById('producto');
    const productoId = productoSelect.value;
    const productoNombre = productoSelect.options[productoSelect.selectedIndex].text;
    const cantidad = parseInt(document.getElementById('cantidad').value);
    const precio = parseFloat(document.getElementById('precio').value);

    if (!productoId || cantidad <= 0 || precio <= 0) {
      alert("Completa correctamente los datos del producto.");
      return;
    }

    const subtotal = (cantidad * precio).toFixed(2);
    productos.push({ id_producto: productoId, cantidad, precio });

    const tabla = document.getElementById('tablaDetalle').getElementsByTagName('tbody')[0];
    const fila = tabla.insertRow();
    fila.innerHTML = `
      <td>${productoNombre}</td>
      <td>${cantidad}</td>
      <td>${precio.toFixed(2)}</td>
      <td>${subtotal}</td>
      <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this, ${productos.length - 1})">Eliminar</button></td>
    `;

    document.getElementById('productosInput').value = JSON.stringify(productos);

    // Limpiar campos
    document.getElementById('producto').selectedIndex = 0;
    document.getElementById('cantidad').value = '';
    document.getElementById('precio').value = '';
  }

  function eliminarProducto(btn, index) {
    productos.splice(index, 1);
    const fila = btn.closest('tr');
    fila.remove();
    document.getElementById('productosInput').value = JSON.stringify(productos);
  }
</script>
-->



      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <?php
      include_once "includes/footer.php";
      ?>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <?php include_once "includes/scripts.php"; ?>
  <script src="../scripts/sweetalert/sweetalert.min.js"></script>
  <script src="../scripts/sweetalert/funciones.js"></script>

  <script  src="../scripts/compras/registrar_compras.js"></script>


</body>

</html>