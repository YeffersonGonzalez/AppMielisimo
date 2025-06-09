<?php
require_once __DIR__ . '/../controllers/conexion_bd.php';

// Verificar conexión con la base de datos
if (!isset($conn)) {
    die("Error: No se pudo conectar a la base de datos.");
}

// Obtener el ID del proveedor a actualizar
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("Error: ID del proveedor no válido.");
}

// Obtener datos del proveedor
$query = "SELECT * FROM proveedores WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$proveedor = $result->fetch_assoc();

if (!$proveedor) {
    die("Error: Proveedor no encontrado.");
}

// Procesar actualización
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Depuración: Verificar datos que llegan en POST
    

    $razon_social = $_POST["razon_social"] ?? "";
    $telefono = $_POST["telefono"] ?? "";
    $email = $_POST["email"] ?? "";
    $direccion = $_POST["direccion"] ?? "";
    $activo = isset($_POST["activo"]) ? 1 : 0;

    // Validar que los valores no estén vacíos antes de actualizar
    if (empty($razon_social) || empty($telefono) || empty($email) || empty($direccion)) {
        die("Error: Todos los campos son obligatorios.");
    }

    // Consulta de actualización corregida
    $updateQuery = "UPDATE proveedores SET razon_social=?, telefono=?, email=?, direccion=?, activo=? WHERE id=?";
    $stmtUpdate = $conn->prepare($updateQuery);
    
    if (!$stmtUpdate) {
        die("Error al preparar la consulta: " . $conn->error);
    }

    $stmtUpdate->bind_param("ssssii", $razon_social, $telefono, $email, $direccion, $activo, $id);

    if ($stmtUpdate->execute()) {
        $mensaje = "Proveedor actualizado exitosamente.";
    } else {
        die("Error en la actualización: " . $stmtUpdate->error);
    }

    $stmtUpdate->close();
}
?>
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
              <h1>Registrar Proveedor</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Registrar</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content box-body ">
        <section class="content-body">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card">
                            <div class="card-header bg-indigo">
                                <h3 class="card-title">Registrar proveedor</h3>
                            </div>
                  <div class="card-body">
                      <?php if (!empty($mensaje)): ?>
                        <div class="alert alert-info"><?php echo $mensaje; ?></div>
                    <?php endif; ?>
                      <form method="POST">
                        <div class="card-body">
                            <label>Razón Social</label>
                            <input type="text" name="razon_social" class="form-control" value="<?php echo htmlspecialchars($proveedor['razon_social']); ?>" required>

                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="<?php echo htmlspecialchars($proveedor['telefono']); ?>" required>

                            <label>Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($proveedor['email']); ?>" required>

                            <label>Dirección</label>
                            <input type="text" name="direccion" class="form-control" value="<?php echo htmlspecialchars($proveedor['direccion']); ?>" required>

                            <label>Estado</label>
                            <select name="activo" class="form-control">
                                <option value="1" <?php echo ($proveedor['activo'] == 1) ? 'selected' : ''; ?>>Activo</option>
                                <option value="0" <?php echo ($proveedor['activo'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                            </select>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Guardar cambios</button>
                            <a href="lista_proveedores.php" class="btn btn-warning">Regresar</a>
                        </div>
                    </form>


                    </div>
                    <!-- /.card-body -->
                  </div>
                  </div>
                  </section>

       
            <!-- /.content -->
          </div>
              </div>
            </div>
          </div>
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


 </script>
  <script src="../scripts/sweetalert/sweetalert.min.js"></script>
  <script src="../scripts/sweetalert/funciones.js"></script>



</body>

</html>