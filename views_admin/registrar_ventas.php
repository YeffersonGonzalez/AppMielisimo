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

        <form action="guardar_venta.php" method="POST">
  <!-- Cliente o datos generales -->
  <div class="form-group">
    <label>Fecha de Venta:</label>
    <input type="date" id="fch_venta" name="fc_venta" class="form-control" required>
  </div>

  <!-- Lista dinámica de productos -->
  <div id="productos">
    <div class="row producto-item">
      <div class="col-md-5">
        <select name="producto_id[]" id="producto_id" class="form-control">
          <option value="">Seleccione un producto</option>
          <option value="1">Galletas</option>
          <option value="2">Jugo</option>
        </select>
      </div>
      <div class="col-md-3">
        <input type="number" name="cantidad[]" id="cantidad" class="form-control" placeholder="Cantidad" required>
      </div>
      <div class="col-md-3">
        <input type="number" name="precio[]" id="precio" class="form-control" placeholder="Precio" required>
      </div>
      <div class="col-md-1">
        <button type="button" class="btn btn-danger remove-product"><i class="fas fa-trash"></i></button>
      </div>
    </div>
  </div>

  <!-- Botón para agregar otro producto -->
  <button type="button" class="btn btn-info btn-sm" id="agregar_producto"><i class="fas fa-plus"></i> Agregar producto</button>

  <!-- Totales -->
  <div class="form-group mt-3">
    <label>IVA:</label>
    <input type="number" name="iva" id="iva" class="form-control" step="0.01">
    <label>Total:</label>
    <input type="number" name="total" id="total" class="form-control" step="0.01" required>
  </div>

  <!-- Botón guardar -->
  <button type="submit" id="BtnGuardarV" class="btn btn-success"><i class="fas fa-save"></i> Guardar Venta</button>
</form>
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

  <script  src="../scripts/ventas/registrar_ventas.php"></script>



</body>

</html>