<aside class="main-sidebar <?php echo $lateralStyle; ?> elevation-4">

  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="../imgs/logo.png" alt="Mielisimo Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><b>Mielissimo</b></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar" style="height: calc(100vh - 56px); overflow-y: auto;">

    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../imgs/usuarios/user.png" class="img-circle elevation-2" alt="Usuario">
      </div>
      <div class="info d-block">
        Administrador - Inventario
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <!-- PRODUCTOS -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-box" style="<?php echo $iconColors['inventario'] ?? ''; ?>"></i>
            <p>
              Productos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="registrar_productos.php" class="nav-link">
                <i class="fas fa-plus-circle nav-icon" style="<?php echo $iconColors['prod_registrar'] ?? ''; ?>"></i>
                <p>Registrar productos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="lista_productos.php" class="nav-link">
                <i class="fas fa-list nav-icon" style="<?php echo $iconColors['prod_listar'] ?? ''; ?>"></i>
                <p>Lista de productos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="lista_marcas.php" class="nav-link">
                <i class="fas fa-tags nav-icon" style="<?php echo $iconColors['prod_marca'] ?? ''; ?>"></i>
                <p>Marcas</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- PERFILES -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user" style="<?php echo $iconColors['perfiles'] ?? ''; ?>"></i>
            <p>
              Perfiles
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="registrar_usuario.php" class="nav-link">
                <i class="fas fa-user-plus nav-icon" style="<?php echo $iconColors['usu_registro'] ?? ''; ?>"></i>
                <p>Registro de usuarios</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="lista_usuarios.php" class="nav-link">
                <i class="fas fa-user-friends nav-icon" style="<?php echo $iconColors['usu_lista'] ?? ''; ?>"></i>
                <p>Lista de usuarios</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="gestion_roles.php" class="nav-link">
                <i class="fas fa-user-tag nav-icon"></i>
                <p>Rol</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- PROVEEDORES -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-truck" style="<?php echo $iconColors['proveedores'] ?? ''; ?>"></i>
            <p>
              Proveedores
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="registrar_proveedores.php" class="nav-link">
                <i class="fas fa-plus nav-icon" style="<?php echo $iconColors['prov_registro'] ?? ''; ?>"></i>
                <p>Registro de proveedores</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="lista_proveedores.php" class="nav-link">
                <i class="fas fa-address-book nav-icon" style="<?php echo $iconColors['prov_lista'] ?? ''; ?>"></i>
                <p>Lista de proveedores</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- COMPRAS -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart" style="<?php echo $iconColors['compras'] ?? ''; ?>"></i>
            <p>
              Compras
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="compras.php" class="nav-link">
                <i class="fas fa-cart-arrow-down nav-icon"></i>
                <p>Registrar compras</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="historial_compras.php" class="nav-link">
                <i class="fas fa-receipt nav-icon" style="<?php echo $iconColors['compra_detalle'] ?? ''; ?>"></i>
                <p>Detalle de compra</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- VENTAS -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-store" style="<?php echo $iconColors['ventas'] ?? ''; ?>"></i>
            <p>
              Ventas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="registrar_ventas.php" class="nav-link">
                <i class="fas fa-plus-square nav-icon" style="<?php echo $iconColors['venta_registro'] ?? ''; ?>"></i>
                <p>Registro de ventas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="detalle_ventas.php" class="nav-link">
                <i class="fas fa-receipt nav-icon" style="<?php echo $iconColors['venta_detalle'] ?? ''; ?>"></i>
                <p>Detalle de venta</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- REPORTES -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie" style="<?php echo $iconColors['reportes'] ?? ''; ?>"></i>
            <p>
              Reportes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-warehouse nav-icon" style="<?php echo $iconColors['reporte_inventario'] ?? ''; ?>"></i>
                <p>Inventario Actual</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-file-invoice-dollar nav-icon" style="<?php echo $iconColors['reporte_compras'] ?? ''; ?>"></i>
                <p>Compras</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-cash-register nav-icon" style="<?php echo $iconColors['reporte_ventas'] ?? ''; ?>"></i>
                <p>Ventas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-exchange-alt nav-icon" style="<?php echo $iconColors['reporte_movimientos'] ?? ''; ?>"></i>
                <p>Movimientos de Inventario</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-star nav-icon" style="<?php echo $iconColors['reporte_mas_vendidos'] ?? ''; ?>"></i>
                <p>Más Vendidos</p>
              </a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->

  </div>
  <!-- /.sidebar -->

</aside>
