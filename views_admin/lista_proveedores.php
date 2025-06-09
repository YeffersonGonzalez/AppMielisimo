<?php
require_once __DIR__ . '/../models/models_admin.php';

try {
    $db = new DBConfig();
    $db->config();
    $db->conexion();

    $proveedores = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["txtBuscar"])) {
        $proveedores = $db->buscarProveedorPorNombre($_POST["txtBuscar"]); // Filtrar por nombre
    } else {
        $proveedores = $db->getProveedores(); // Obtener todos los proveedores
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
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
      <?php include_once "includes/header.php"; ?>
    </nav>
    <!-- /.navbar -->

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
              <h1>Lista de Proveedores</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Proveedores</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="card-body">
          <table class="table table-bordered table-hover">
            <form method="POST" class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="txtBuscar" class="form-control" placeholder="Buscar por nombre...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form><br>
            <thead>
              <tr>
                <th>ID</th>
                <th>Razón Social</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Estado</th>
                <th>Accion</th>
              </tr>
            </thead>
            <tbody id="proveedorBody">
                <?php if ($proveedores && count($proveedores) > 0): ?>
                    <?php foreach ($proveedores as $proveedor): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($proveedor['id']); ?></td>
                            <td><?php echo htmlspecialchars($proveedor['razon_social']); ?></td>
                            <td><?php echo htmlspecialchars($proveedor['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($proveedor['email']); ?></td>
                            <td><?php echo htmlspecialchars($proveedor['direccion']); ?></td>
                            <td><?php echo $proveedor['activo'] ? "Activo" : "Inactivo"; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm btn-editar" data-id="<?php echo $proveedor['id']; ?>">Editar</button>
                                <button class="btn btn-danger btn-sm btn-eliminar" data-id="<?php echo $proveedor['id']; ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No hay proveedores registrados</td></tr>
                <?php endif; ?>
            </tbody>

          </table>
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <?php include_once "includes/footer.php"; ?>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
   <script>
   
        document.addEventListener("DOMContentLoaded", function() {
            // Acción de eliminar producto
            document.querySelectorAll(".btn-eliminar").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
                        fetch(`delete_proveedores.php?id=${id}`, {
                            method: "DELETE"
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.mensaje || data.error);
                            location.reload();
                        })
                        .catch(error => console.error("Error:", error));
                    }
                });
            });

            // Acción de editar producto
            document.querySelectorAll(".btn-editar").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    window.location.href = `actualizar_proveedor.php?id=${id}`;
                });
            });
        });

        document.getElementById("btnBuscar").addEventListener("click", function() {
                filtrarproveedor();
            });

            function filtrarproveedor() {
                let input = document.getElementById("searchBox").value.toLowerCase();
                let filas = document.querySelectorAll("#proveedorBody tr");

                filas.forEach(fila => {
                    let textoFila = fila.innerText.toLowerCase();
                    fila.style.display = textoFila.includes(input) ? "" : "none";
                });
            }


    </script>
   </script>

  <?php include_once "includes/scripts.php"; ?>

</body>

</html>
