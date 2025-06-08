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
      <?php include_once "includes/header.php"; ?>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar <?php echo $lateralStyle; ?> elevation-4">
      <?php include_once "includes/lateralaside.php"; ?>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Título Página</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Título Corto</li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- Formulario -->
            <div class="col-md-4">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Registrar Rol</h3>
                </div>
                <div class="card-body">
                  <form action="insertar_rol.php" method="POST">
                    <div class="form-group">
                      <label for="tipo_rol">Nombre del Rol</label>
                      <input type="text" class="form-control" id="tipo_rol" name="tipo_rol" required>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary">Guardar Rol</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- Tabla -->
            <div class="col-md-8">
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Lista de Roles</h3>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Tipo de Rol</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php /*
                      // include 'config.php'; // ya está incluido arriba
                      $resultado = mysqli_query($conn, "SELECT * FROM roles");
                      while ($row = mysqli_fetch_assoc($resultado)) :
                      */?>
                        <tr>
                          <td><? /*= $row['id']; */?></td>
                          <td><? /*= $row['tipo_rol']; */?></td>
                          <td>
                            <a href="editar_rol.php?id=<? /*= $row['id']; */?>" class="btn btn-warning btn-sm">
                              <i class="fas fa-edit"></i>
                            </a>
                            <a href="eliminar_rol.php?id=<? /*= $row['id']; */?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                              <i class="fas fa-trash"></i>
                            </a>
                          </td>
                        </tr>
                      <?php /*endwhile; */?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- Fin de col-md-8 -->
          </div>
        </div>
      </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
      <?php include_once "includes/footer.php"; ?>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>

  <?php include_once "includes/scripts.php"; ?>
</body>

</html>
