<?php
require 'config.php'
?>

<!DOCTYPE html>

<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Farmacia | <?php echo $paginaActual; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>dist/css/adminlte.min.css">
  <!--select2-->
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>plugins/select2/css/select2.min.css">
  <!--JQUERY-->
  <script src="<?php echo BASE_URL; ?>plugins/jquery/jquery.min.js"></script>
  <style>
    .ir-arriba {
      display: none;
      background-repeat: no-repeat;
      font-size: 20px;
      color: black;
      cursor: pointer;
      position: fixed;
      bottom: 10px;
      right: 10px;
      z-index: 2;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">