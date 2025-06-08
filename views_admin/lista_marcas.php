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
        <div class="row">
          <div class="col-md-4">
            <!-- registrar_rol.php -->
            <div class="card card-success">
              <div class="card-header">
                <h1 class="card-title">Registrar marca de producto</h1>
              </div>
              <div class="card-body">
                <form action="registrar_marcas.js" method="POST">

                  <div class="form-group">
                    <label for="txtId">Id de la marca</label>
                    <input disabled type="text" class="form-control" id="txtId" name="txtId" required>
                  </div>
                  <div class="form-group">
                    <label for="txtCodigo">Codigo de la marca</label>
                    <input type="text" class="form-control" id="txtCodigo" name="txtCodigo" required>
                  </div>
                  <div class="form-group">
                    <label for="txtNombre">Nombre de la marca</label>
                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" required>
                  </div>

                  <div class="card-footer">
                    <button id="BtnLimpiar" type="submit" class="btn btn-primary">Limpiar</button>
                    <button id="BtnGuardar" type="submit" class="btn btn-primary">Registrar</button>
                    <button id="BtnActualizar" type="submit" class="btn btn-primary">Actualizar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>


          <div class="col-md-8">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Lista de marcas</h3>
              </div>
              <div class="card-body">
                <input type="text" id="search" class="form-control" placeholder="Buscar productos..." aria-label="Buscar">
                <table class="table table-bordered table-striped">
                  <thead id="header_table">
                  </thead>
                  <tbody id="body_table">
                  </tbody>
                </table>
              </div>
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

  <script src="../scripts/marcas/listar_marcas.js"></script>
  <script src="../scripts/marcas/registrar_marcas.js"></script>
</body>

</html>