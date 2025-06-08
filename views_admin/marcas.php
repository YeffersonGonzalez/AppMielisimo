<!DOCTYPE html>
<html>
<head>
  <?php include "includes/head.php"; ?>
</head>
<body class="sidebar-collapse sidebar-mini">

<?php include "includes/config.php"; ?>

<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand <?php echo $headerStyle; ?>">
    <?php 
      include "includes/header.php";
    ?>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar <?php echo $lateralStyle; ?> elevation-4">
    <?php 
    include "includes/lateralaside.php";
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


<!-- Contenido AdminLTE -->
<section class="content">
  <div class="container-fluid">
    <h2>Gestión de Marcas</h2>
    <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalMarca">Agregar Marca</button>
    
    <div class="card">
      <div class="card-body">
        <table id="tablaMarcas" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <!-- /*php
              $resultado = mysqli_query($conexion, "SELECT * FROM marcas");
              while($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>
                        <td>{$fila['id']}</td>
                        <td>{$fila['nombre']}</td>
                        <td>{$fila['estado']}</td>
                        <td>
                          <button class='btn btn-sm btn-warning'>Editar</button>
                          <button class='btn btn-sm btn-danger'>Eliminar</button>
                        </td>
                      </tr>";
              }
                      */-->
            </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Modal para registrar marca -->
<div class="modal fade" id="modalMarca" tabindex="-1" role="dialog" aria-labelledby="modalMarcaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="insertar_marca.php" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalMarcaLabel">Agregar Marca</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nombre">Nombre de la Marca</label>
            <input type="text" class="form-control" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" name="estado">
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Scripts necesarios (jQuery, Bootstrap, DataTables)
<script>
  $(document).ready(function () {
    $('#tablaMarcas').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
      }
    });
  });
</script>  -->


<form class="form-inline mb-3">
  <select name="tipo" class="form-control mr-2">
    <option value="">Todos</option>
    <option value="entrada">Entrada</option>
    <option value="salida">Salida</option>
  </select>
  <input type="date" name="desde" class="form-control mr-2">
  <input type="date" name="hasta" class="form-control mr-2">
  <button type="submit" class="btn btn-primary">Filtrar</button>
</form>

<table id="tablaMovimientos" class="table table-bordered table-striped">
  <thead>
    <tr>
      <th>Fecha</th>
      <th>Producto</th>
      <th>Tipo</th>
      <th>Cantidad</th>
      <th>Usuario</th>
      <th>Motivo</th>
    </tr>
  </thead>
  <tbody>
    <!-- Filas dinámicas desde PHP o JS -->
  </tbody>
</table>


      


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <?php 
      include "includes/footer.php";
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