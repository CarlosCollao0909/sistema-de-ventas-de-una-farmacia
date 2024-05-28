<?php
require '../includes/config.php';
session_start();
if (!isset($_SESSION['personal']) || empty($_SESSION['personal'])) {
  header("Location:" . BASE_URL . "login/");
}

$paginaActual = 'Dashboard';
include '../includes/header.php';
include '../includes/navbar.php';
?>

<?php
$query = "SELECT COUNT(*) AS clientes FROM cliente";
$resultado = mysqli_query($conn, $query);
$fila = mysqli_fetch_array($resultado);
$clientes = $fila['clientes'];
?>

<?php
$query = "SELECT COUNT(*) AS ventas FROM venta";
$resultado = mysqli_query($conn, $query);
$fila = mysqli_fetch_array($resultado);
$ventas = $fila['ventas'];
?>

<?php
$query = "SELECT COUNT(*) AS farmacoStock FROM farmaco WHERE stock <= 20";
$resultado = mysqli_query($conn, $query);
$fila = mysqli_fetch_array($resultado);
$farmacoStock = $fila['farmacoStock'];
?>

<?php
$queryStock = "SELECT f.*, f.nombre AS nombre_farmaco, p.nombre AS nombre_proveedor, p.telefono AS telefono_proveedor 
              FROM farmaco f
              JOIN proveedor p ON f.ID_Proveedor = p.ID_Proveedor WHERE stock <= 20";
$resultadoStock = $conn->query($queryStock);
?>

<?php
$query = "SELECT COUNT(*) AS vencimientoFarmacos FROM farmaco WHERE fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)";
$resultado = mysqli_query($conn, $query);
$fila = mysqli_fetch_array($resultado);
$vencimientoFarmacos = $fila['vencimientoFarmacos'];
?>

<?php
$queryVencimiento = "SELECT f.*, f.nombre AS nombre_farmaco, p.nombre AS nombre_proveedor, p.telefono AS telefono_proveedor
FROM farmaco f
JOIN proveedor p ON f.ID_Proveedor = p.ID_Proveedor WHERE fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 3 MONTH)";
$resultadoVencimiento = $conn->query($queryVencimiento);
?>

<?php
$sql = "SELECT farmaco.nombre, SUM(detalle_venta.cantidad) as total_farmacos_vendidos 
        FROM detalle_venta 
        INNER JOIN farmaco ON detalle_venta.ID_Farmaco = farmaco.ID_Farmaco 
        GROUP BY farmaco.ID_Farmaco 
        ORDER BY total_farmacos_vendidos DESC 
        LIMIT 5";
$resultado = $conn->query($sql);

$nombresFarmacos = [];
$cantidadVentas = [];

if ($resultado->num_rows > 0) {
  while ($row = $resultado->fetch_assoc()) {
    $nombresFarmacos[] = $row["nombre"];
    $cantidadVentas[] = $row["total_farmacos_vendidos"];
  }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <?php
          // Si hay farmacos que vence pronto, mostrar la alerta
          if ($vencimientoFarmacos > 0) {
            echo '<div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h6><i class="icon fas fa-bell"></i> Alerta! Hay farmacos que vencerán pronto.</h6>
        </div>';
          }
          // Si hay fármacos con poco stock, mostrar la alerta
          if ($farmacoStock > 0) {
            echo '<div class="alert alert-warning alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h6><i class="icon fas fa-exclamation-triangle"></i> Alerta! Hay fármacos con poco stock.</h6>
        </div>';
          }
          ?>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo $ventas; ?></h3>

              <p>Ventas Realizadas</p>
            </div>
            <div class="icon">
              <i class="fas fa-cart-plus"></i>
            </div>
            <a href="<?php echo BASE_URL; ?>ventas/" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo $clientes; ?></h3>

              <p>Clientes Registrados</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?php echo BASE_URL; ?>clientes" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3 class="text-white"><?php echo $farmacoStock; ?></h3>

              <p class="text-white">Farmacos con poco stock</p>
            </div>
            <div class="icon">
              <i class="fa fa-exclamation-triangle"></i>
            </div>
            <button type="button" class="small-box-footer btn btn-block" data-toggle="modal" data-target="#modal-lg">Más información <i class="fas fa-arrow-circle-right"></i></button>
            <div class="modal fade" id="modal-lg">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Farmacos con poco stock</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Stock Restante</th>
                          <th scope="col">Contacto Proveedor</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if ($resultadoStock->num_rows > 0) {
                          while ($row = $resultadoStock->fetch_assoc()) {
                        ?>
                            <tr>
                              <td><?php echo $row['ID_Farmaco'] ?></td>
                              <td><?php echo $row['nombre_farmaco'] ?></td>
                              <td><?php echo $row['stock'] ?></td>
                              <td><?php echo $row['nombre_proveedor'] . " - " . $row['telefono_proveedor'] ?></td>
                            </tr>
                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger text-dark">
            <div class="inner">
              <h3><?php echo $vencimientoFarmacos; ?></h3>

              <p>Fármacos prontos a vencer</p>
            </div>
            <div class="icon">
              <i class="fa fa-calendar"></i>
            </div>
            <button type="button" class="small-box-footer btn btn-block" data-toggle="modal" data-target="#modal-default">Más información <i class="fas fa-arrow-circle-right"></i></button>
            <div class="modal fade text-dark" id="modal-default">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Farmacos prontos a vencer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Fecha de vencimiento</th>
                          <th scope="col">Contacto Proveedor</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if ($resultadoVencimiento->num_rows > 0) {
                          while ($row = $resultadoVencimiento->fetch_assoc()) {
                        ?>
                            <tr>
                              <td><?php echo $row['ID_Farmaco'] ?></td>
                              <td><?php echo $row['nombre_farmaco'] ?></td>
                              <td><?php echo $row['fecha_vencimiento'] ?></td>
                              <td><?php echo $row['nombre_proveedor'] . " - " . $row['telefono_proveedor'] ?></td>
                            </tr>
                        <?php
                          }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row mt-3">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Ventas por Mes</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Farmacos más vendidos</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="graficoTorta" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
include '../includes/footer.php';
?>
<script>
  $(function() {
    $("#table1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#table2').DataTable({
      "paging": true,
      "lengthChange": false,
      "lengthMenu": [3, 5, 10, 25, 50, "All"],
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  // Get context with jQuery - using jQuery's .get() method.

  $.ajax({
    url: 'ventasMes.php',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
      var areaChartData = {
        labels: ['En', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        datasets: [{
          label: 'Ventas por Mes',
          backgroundColor: 'rgba(60,141,188,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          pointRadius: false,
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: data,
        }]
      };

      // Configura el gráfico de ventas por mes
      var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
      var areaChart = new Chart(areaChartCanvas, {
        type: 'line',
        data: areaChartData,
        options: {
          maintainAspectRatio: false,
          responsive: true,
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              gridLines: {
                display: true,
              }
            }],
            yAxes: [{
              gridLines: {
                display: true,
              }
            }],
            tooltips: {
              mode: 'dataset',
              intersect: false,
              callbacks: {
                label: function(tooltipItem, data) {
                  var label = data.datasets[tooltipItem.datasetIndex].label || '';
                  if (label) {
                    label += ': ';
                  }
                  label += tooltipItem.yLabel + 'Bs.';
                  return label;
                }
              }
            },
          }
        }
      });
      var ctx = document.getElementById('graficoTorta').getContext('2d');
      var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: <?php echo json_encode($nombresFarmacos); ?>, // Nombres de los fármacos
          datasets: [{
            data: <?php echo json_encode($cantidadVentas); ?>, // Cantidad de ventas
            backgroundColor: [
              'rgba(245, 105, 84, 0.9)',
              'rgba(0, 166, 90, 0.9)',
              'rgba(243, 156, 18, 0.9)',
              'rgba(0, 192, 239, 0.9)',
              'rgba(60, 141, 188, 0.9)'
            ],
            borderColor: [
              '#f56954',
              '#00a65a',
              '#f39c12',
              '#00c0ef',
              '#3c8dbc'
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: false, // Para que el tamaño del gráfico no sea responsive
        }
      });
    }

  });


  var areaChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: true,
        }
      }],
      yAxes: [{
        gridLines: {
          display: true,
        }
      }]
    }
  }
</script>