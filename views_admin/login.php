<!DOCTYPE html>
<html>

<head>
  <?php include_once 'includes/head.php'; ?>
  <style>
  body.login-page {
    margin: 0;
    padding: 0;
    min-height: 100vh; /* Asegura que cubra toda la pantalla verticalmente */
    background: url('../imgs/logo.png') no-repeat center center fixed;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed
  }
</style>

</head>

    <!-- Main content -->

    <body class="hold-transition login-page">
      <div class="login-box">
        <div class="card">
          <div class="login-logo mt-4">
          <h3><b>Sistema Mielissimo</b></h3>
        </div>
          <div class="card-body login-card-body">
            <p class="login-box-msg">Iniciar sesion</p>

            <form action="login.php" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Contraseña" name="contraseña" id="">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
                <!-- /.col -->
                <div class="col-4">
                  <button id="login" type="submit" class="btn btn-success">Ingresar</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
      </div>
      <!-- /.login-box -->

      <?php include_once 'includes/scripts.php'; ?>
      <script src="../scripts/mas/login.js"></script>

    </body>

</html>