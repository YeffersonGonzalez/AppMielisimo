<!DOCTYPE html>
<html>
<head>
  <?php include_once "includes/head.php"; ?>
</head>
<body class="sidebar-collapse sidebar-mini custom-body">

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
              <h1>Registro de Compras</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="row">

          <div class="col-md-10 col-md-10 offset-md-1"><!-- columna de contenido -->
            <div class="card">
              <div class="card-header bg-indigo">
                <h3 class="card-title">Productos</h3>
              </div>

              <form action="productos_disponibles.php" method="post">
                <div class="card-body">
                  <div class="row g-3">

                    <div class="col-md-6">
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del producto" required>
                    </div>

                    <div class="col-md-6">
                      <label for="codigo">Código de producto</label>
                      <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código del producto" required>
                    </div>

                    <div class="col-md-6">
                      <label for="stock">Stock</label>
                      <input type="number" class="form-control" id="stock" name="stock" placeholder="Cantidad disponible" required>
                    </div>

                    <div class="col-md-6">
                      <label for="stock_minimo">Stock mínimo</label>
                      <input type="number" class="form-control" id="stock_minimo" name="stock_minimo" placeholder="Cantidad mínima" required>
                    </div>

                    <div class="col-md-6">
                      <label for="precio_compra">Precio de compra</label>
                      <input type="number" step="0.01" class="form-control" id="precio_compra" name="precio_compra" placeholder="Precio compra" required>
                    </div>

                    <div class="col-md-6">
                      <label for="precio_venta">Precio de venta</label>
                      <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta" placeholder="Precio venta" required>
                    </div>

                    <div class="col-md-6">
                      <label for="fecha_vencimiento">Fecha de vencimiento</label>
                      <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" required>
                    </div>

                    <div class="col-md-6">
                      <label for="id_marca">Marca</label>
                      <select class="form-control" name="id_marca" id="id_marca" required>
                        <option value="">Seleccionar</option>
                        <?php
                        $consulta = mysqli_query($conn, "SELECT id, nombre FROM marcas WHERE estado='activo'");
                        while ($row = mysqli_fetch_assoc($consulta)) {
                          echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                        }
                        ?>
                      </select>
                    </div>

                    <div class="col-md-12">
                      <label for="observaciones">Observaciones</label>
                      <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Observaciones..."></textarea>
                    </div>

                  </div>
                </div>

                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Registrar producto
                  </button>
                  <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-eraser"></i> Limpiar campos
                  </button>
                </div>

              </form>
            </div>
          </div>

          <!-- ... (continúa todo igual después del formulario) -->

        </div>
      </section>
    </div>

    <footer class="main-footer">
      <?php include_once "includes/footer.php"; ?>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>

  <?php include_once "includes/scripts.php"; ?>
</body>
</html>
