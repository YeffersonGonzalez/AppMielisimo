<?php
require_once __DIR__ . '/../models/models_admin.php';

try {
    $db = new DBConfig();
    $db->config();
    $db->conexion();

    $marcas = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["txtBuscar"])) {
        $marcas = $db->buscarMarcasPorNombre($_POST["txtBuscar"]); // Filtrar por nombre
    } else {
        $marcas = $db->getMarcas(); // Obtener todos los marcas
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

  <div class="wrapper">
    <nav class="main-header navbar navbar-expand <?php echo $headerStyle; ?>">
      <?php include_once "includes/header.php"; ?>
    </nav>

    <aside class="main-sidebar <?php echo $lateralStyle; ?> elevation-4">
      <?php include_once "includes/lateralaside.php"; ?>
    </aside>

    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Gestión de Marcas</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="row">
          <!-- Formulario de registro de marcas -->
          <div class="col-md-4">
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Registrar marca de producto</h3>
              </div>
              <div class="card-body">
                <form id="marcaForm">
                  <div class="form-group">
                    <label for="activo1">Estado de la Marca</label>
                    <select class="form-control" name="activo1" id="activo1">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="txtNombre">Nombre de la marca</label>
                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" required>
                  </div>

                  <div class="card-footer">
                    <button id="BtnLimpiar" type="reset" class="btn btn-secondary">Limpiar</button>
                    <button id="BtnGuardar" class="btn btn-primary">Registrar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Listado de marcas con búsqueda -->
          <div class="col-md-8">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Lista de marcas</h3>
              </div>
              <div class="card-body">
                <form method="POST" class="mb-3">
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" name="txtBuscar" class="form-control" placeholder="Buscar por nombre...">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody id="body_table">
                    <?php if (!empty($marcas)): ?>
                        <?php foreach ($marcas as $marca): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($marca['id']); ?></td>
                                <td><?php echo htmlspecialchars($marca['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($marca['activo']); ?></td>
                                
                                <td>
                                    

                                    <button class="btn btn-warning btn-sm btn-editar" data-id="<?php echo $marca['id']; ?>">Editar</button>
                                    <button class="btn btn-danger btn-sm btn-eliminar" data-id="<?php echo $marca['id']; ?>">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4">No hay marcas registradas</td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
<div class="modal fade" id="modal-sm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Actualizar Marca</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="actualizar">
                    <div class="form-group">
                        <label for="nombre">Nombre de la marca</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="updateActivo">Estado</label>
                        <select id="updateActivo" class="form-control" name="activo">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <footer class="main-footer">
      <?php include_once "includes/footer.php"; ?>
    </footer>
  </div>

  <?php include_once "includes/scripts.php"; ?>


  <script>
    document.getElementById("BtnGuardar").addEventListener("click", function(event) {
    event.preventDefault();
    
    // Capturar datos del formulario
    const formData = new FormData(document.getElementById("marcaForm"));
    const jsonData = Object.fromEntries(formData.entries());

    // Validar que el nombre no esté vacío
    if (!jsonData.txtNombre.trim()) {
        alert("Por favor, ingrese un nombre válido.");
        return;
    }

    console.log("Datos enviados:", jsonData); // Depuración

    fetch("../api/marcas/registrar_marca.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(jsonData)
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta API:", data);
        alert(data.mensaje || data.error);
        location.reload();
    })
    .catch(error => console.error("Error:", error));
});
  
 document.getElementById("body_table").addEventListener("click", function(event) {
    const id = event.target.getAttribute("data-id");

   if (event.target.classList.contains("btn-eliminar")) {
        if (confirm("¿Estás seguro de eliminar la marca con ID: " + id + "?")) {
            fetch(`../api/marcas/eliminar_marca.php?id=${id}`, {
                method: "DELETE",
                headers: { "Content-Type": "application/json" }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.mensaje || data.error);
                location.reload();
            })
            .catch(error => console.error("Error:", error));
        }
    }
});
document.querySelectorAll(".btn-editar").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    window.location.href = `actualizar_marca.php?id=${id}`;
                });
            });
</script>


</div>
</body>
</html>
