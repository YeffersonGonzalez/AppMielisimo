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
<!--
      <div id="detalle_venta">
  <div class="row producto-item mb-2">
    <div class="col-md-4">
      <select name="producto_id[]" class="form-control" required>
        <option value="">Seleccione un producto</option>
        <option value="1">Galletas</option>
        <option value="2">Refresco</option>
        llenar dinámicamente desde la BD
      </select>
    </div>
    <div class="col-md-2">
      <input type="number" name="cantidad[]" class="form-control" placeholder="Cantidad" required>
    </div>
    <div class="col-md-3">
      <input type="number" name="precio_venta[]" class="form-control" placeholder="Precio unitario" step="0.01" required>
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control subtotal" placeholder="Subtotal" readonly>
    </div>
    <div class="col-md-1">
      <button type="button" class="btn btn-danger remove-product"><i class="fas fa-times"></i></button>
    </div>
  </div>
</div>

<button type="button" class="btn btn-info btn-sm" id="agregar_producto"><i class="fas fa-plus"></i> Agregar Producto</button>
-->

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Ventas registradas</h3>
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
            <?php /*
            include("config/conexion.php");
            $sql = "SELECT v.*, u.nombre as usuario 
                    FROM ventas v
                    JOIN usuarios u ON v.id_usuario = u.id";
            $result = mysqli_query($conexion, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                      <td>{$row['codigo']}</td>
                      <td>{$row['fc_venta']}</td>
                      <td>{$row['total']}</td>
                      <td>{$row['iva']}</td>
                      <td>{$row['usuario']}</td>
                      <td>
                        <a href='ver_venta.php?id={$row['id']}' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a>
                        <a href='eliminar_venta.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Eliminar esta venta?\")'><i class='fas fa-trash'></i></a>
                      </td>
                    </tr>";
            }
           */ ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>


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


</body>

</html>
<!--
<script>
  $(document).ready(function () {
    $('#tablaVentas').DataTable({
      "language": {
        "url": "plugins/datatables/es_es.json" // Traducción opcional
      }
    });
  });
</script>

-->



