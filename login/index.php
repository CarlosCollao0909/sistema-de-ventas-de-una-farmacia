<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition login-page">

  <div class="login-box">
    <?php
    session_start();
    if (isset($_SESSION['mensaje'])) {
      $mensaje = $_SESSION['mensaje']; ?>
      <script>
        Swal.fire({
          position: "top-end",
          icon: "error",
          title: "<?php echo $mensaje ?>",
          showConfirmButton: false,
          timer: 2000
        });
      </script>
    <?php
      unset($_SESSION['mensaje']);
    }
    ?>

    
    <!-- /.login-logo -->
    <h1 class="text-center"><b>Farmacia Jhessmin</b></h1>
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <h3><b>Iniciar Sesión</b></h3>
      </div>
      <div class="card-body">

        <form action="ingreso.php" method="POST" autocomplete="off">
          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Password" required>
          </div>
          <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
              <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </div>
            <div class="col-2"></div>
          </div>
        </form>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>