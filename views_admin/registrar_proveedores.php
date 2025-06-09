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
                      
                      <form id="registroForm">
                        <div class="form-group">
                            <label for="RazonSocial">Razón Social</label>
                            <input class="form-control" type="text" id="RazonSocial" name="RazonSocial" placeholder="Ingresar razón social">
                        </div>

                        <div class="form-group">
                            <label for="Telefono">Teléfono</label>
                            <input class="form-control" type="number" id="Telefono" name="Telefono" placeholder="Ingresar teléfono">
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input class="form-control" type="text" id="email" name="email" placeholder="Ingresar email">
                        </div>

                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input class="form-control" type="text" id="direccion" name="direccion" placeholder="Ingresar dirección">
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

  <?php include_once "includes/scripts.php"; ?>
  <script>
    document.getElementById("BtnGuardar").addEventListener("click", function() {
            const formData = new FormData(document.getElementById("registroForm"));
            const jsonData = Object.fromEntries(formData.entries());

            fetch("crear_proveedor_api.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(jsonData)
            })
            .then(response => response.json())
            .then(data => alert(data.mensaje || data.error))
            .catch(mensaje => {
                if (mensaje.error) {
                    alert(mensaje.error);
                } else {
                    alert("Proveedor registrado exitosamente.");
                    document.getElementById("registroForm").reset();
                }
            })
            .catch(error => {
                alert("Error al registrar el producto.");
                console.error(error);
            });
        });
        
 </script>
  <script src="../scripts/sweetalert/sweetalert.min.js"></script>
  <script src="../scripts/sweetalert/funciones.js"></script>



</body>

</html>