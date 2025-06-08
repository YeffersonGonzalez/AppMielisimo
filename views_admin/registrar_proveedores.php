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

       <div class="col-md-6">
            <!-- Form Element sizes -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Registrar proveedor</h3>
              </div>
              <div class="card-body">
                <form action="registrar_proveedores.php" method="POST">
                 <div class="form-group">
                    <label for="">Razon social</label>
                <input class="form-control" type="text" id="RazonSocial" placeholder="Ingresar razon social">
                </div>

                <div class="form-group">
                    <label for="">Telefono</label>
                <input class="form-control" type="text" id="Telefono" placeholder="Ingresar razon social">
                </div>

                <div class="form-group">
                    <label for="">Correo electronico</label>
                <input class="form-control" type="text" id="email" placeholder="Ingresar Email">
                </div>

                <div class="form-group">
                    <label for="">Direccion</label>
                <input class="form-control" type="text" id="direccion" placeholder="Ingresar razon social">
                </div>
                
                <div class="form-check">
                    <input type="checkbox" id="ChkActivo" name="activo" class="form-check-input" value="1" checked>
                    <label class="form-check-label">Proveedor activo</label>
                </div>
                    <button type="submit" id="BtnGuardar" class="btn btn-success mt-3">Guardar</button>
                </form>
              </div>
              <!-- /.card-body -->
            </div>

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

  <script  src="../scripts/proveedores/registrar_proveedores.js"></script>


</body>

</html>