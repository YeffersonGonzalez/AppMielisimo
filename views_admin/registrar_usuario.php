
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
              <h1>Registro de usuarios</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>

              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content-body">
        <!-- CONTROLES DE FORMULARIO Y TABLA -->
        <div class="row row justify-content-center"> <!-- fila contenedora -->

          <!-- COLUMNA DE FORMULARIO  -->
           <div class="col-md-10 col-md-10 offset-md-1">
            <div class="card-header bg-primary text-white">Registro de Usuario</div>
            <div class="card-body">
              <form id="form-usuario" action="registrar_usuario.php" method="POST">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Nombre</label>
                    <input type="text" id="nombre" class="form-control" name="nombre" />
                  </div>
                  <div class="form-group col-md-6">
                    <label>Usuario</label>
                    <input type="text" id="usuario"  class="form-control" name="usuario" />
                  </div>
                  <div class="form-group col-md-6">
                    <label>Contraseña</label>
                    <input type="password" id="contraseña" class="form-control" name="pass" />
                  </div>
                  <div class="form-group col-md-6">
                    <label>Rol</label>
                    <select class="form-control" name="id_rol">
                      <option value="">Seleccione un rol</option>
                    </select>
                  </div>
                </div>

                <div class="form-group col-md-6">
                <div class="form-check mt-4">
                  <input class="form-check-input" type="checkbox" name="activo" id="chkActivo" value="1" checked>
                  <label class="form-check-label" for="chkActivo">Usuario activo</label>
                </div>
              </div>
            </div>
                <button type="submit" id="BtnRegistrar" class="btn btn-success">Registrar</button>
                <button type="reset" id="BtnLimpiar"  class="btn btn-secondary">Limpiar</button>
              </form>
            </div>
          </div>
          </div><!-- Fin contenido formulario -->

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

  <script  src="../scripts/usuarios/registrar_usuarios.js"></script>


</body>

</html>