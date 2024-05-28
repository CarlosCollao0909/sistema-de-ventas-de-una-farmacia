<?php
require 'config.php';


if (isset($_SESSION['personal'])) {
  $emailSesion = $_SESSION['personal'];
  $query = "SELECT * FROM personal WHERE email = '$emailSesion'";
  $resultado = mysqli_query($conn, $query);
  foreach ($resultado as $personal) {
    $idSesion = $personal['ID_Personal'];
    $nombreSesion = $personal['nombre'];
    $apellidoSesion = $personal['apellido'];
    $emailSesion = $personal['email'];
    $rolSesion = $personal['rol'];
  }
}
?>

<a class="ir-arriba" javascript:void(0) title="Volver arriba">
  <span class="fa-stack">
    <i class="fa fa-circle fa-stack-2x"></i>
    <i class="fa fa-arrow-up fa-stack-1x fa-inverse"></i>
  </span>
</a>
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo de la institución -->
    <p class="brand-link">
      <img src="<?php echo BASE_URL; ?>dist/img/logoFarmacia.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Farmacia <b>Jhessmin</b> </span>
    </p>

    <!-- Sidebar -->
    <div class="sidebar">

      <div class="user-panel mt-1 pb-2 mb-1 d-flex align-items-center ml-3">
        <div class="image">
          <img src="../dist/img/perfilUsuario.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a class="d-block"><?php echo $nombreSesion . ' ' . $apellidoSesion . ' <br> <small>' . $rolSesion . '</small>'; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <?php
        if ($rolSesion == "Administrador") {
        ?>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>dashboard/" class="nav-link <?php echo ($paginaActual == 'Dashboard') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p> Dashboard </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>clientes/" class="nav-link <?php echo ($paginaActual == 'Clientes') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-users"></i>
                <p> Clientes </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>personal/" class="nav-link <?php echo ($paginaActual == 'Personal') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-user-cog"></i>
                <p> Personal </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>farmacos/" class="nav-link <?php echo ($paginaActual == 'Farmacos') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-briefcase-medical"></i>
                <p> Fármacos </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>categorias/" class="nav-link <?php echo ($paginaActual == 'Categorias') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-th"></i>
                <p> Categorías </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>proveedores/" class="nav-link <?php echo ($paginaActual == 'Proveedores') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-people-carry"></i>
                <p> Proveedores </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>ventas/" class="nav-link <?php echo ($paginaActual == 'Ventas') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p> Ventas </p>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav">
            <a href="<?php echo BASE_URL; ?>login/logout.php" class="btn btn-sm btn-danger ml-auto mt-20">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              Cerrar Sesión
            </a>
          </ul>

        <?php
        }
        ?>

        <?php
        if ($rolSesion == "Ventas") {
        ?>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>clientes/" class="nav-link <?php echo ($paginaActual == 'Clientes') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-users"></i>
                <p> Clientes </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>ventas/" class="nav-link <?php echo ($paginaActual == 'Ventas') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p> Ventas </p>
              </a>
            </li>
          </ul>
          <ul class="navbar-nav">
            <a href="<?php echo BASE_URL; ?>login/logout.php" class="btn btn-sm btn-danger ml-auto mt-20">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              Cerrar Sesión
            </a>
          </ul>

        <?php
        }
        ?>
        <?php
        if ($rolSesion == "Almacenes") {
        ?>
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>farmacos/" class="nav-link <?php echo ($paginaActual == 'Farmacos') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-briefcase-medical"></i>
                <p> Fármacos </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>categorias/" class="nav-link <?php echo ($paginaActual == 'Categorias') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-th"></i>
                <p> Categorías </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="<?php echo BASE_URL; ?>proveedores/" class="nav-link <?php echo ($paginaActual == 'Proveedores') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-people-carry"></i>
                <p> Proveedores </p>
              </a>
            </li>

          </ul>
          <ul class="navbar-nav">
            <a href="<?php echo BASE_URL; ?>login/logout.php" class="btn btn-sm btn-danger ml-auto mt-20">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              Cerrar Sesión
            </a>
          </ul>
        <?php
        }
        ?>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>