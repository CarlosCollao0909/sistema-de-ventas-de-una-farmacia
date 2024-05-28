<?php
require '../includes/config.php';
session_start();
if(!isset($_SESSION['personal']) || empty($_SESSION['personal'])) {
  header("Location:". BASE_URL . "login/");
}

$paginaActual = 'Ventas';
include '../includes/header.php';
include '../includes/navbar.php';
?>

<?php

$sql = "SELECT v.*, c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, p.nombre AS nombre_personal, p.apellido AS apellido_personal
        FROM venta v
        JOIN cliente c ON v.ID_Cliente = c.ID_Cliente
        JOIN personal p ON v.ID_Personal = p.ID_Personal";
$result = $conn->query($sql);

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Ventas</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <a href="agregarVenta.php" class="btn btn-default">
                        Nueva Venta
                    </a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ventas Registradas</h3>
                            
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre Cliente</th>
                                        <th>Nombre Personal</th>
                                        <th>Fecha Venta</th>
                                        <th>Total Venta</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['ID_Venta'] ?></td>
                                                <td><?php echo $row['nombre_cliente'] . ' ' . $row['apellido_cliente'] ?></td>
                                                <td><?php echo $row['nombre_personal'] . ' ' . $row['apellido_personal'] ?></td>
                                                <td><?php echo $row['fecha'] ?></td>
                                                <td><?php echo $row['total_Venta'] ?></td>
                                                <td>
                                                <a href="recibo.php?id=<?php echo $row['ID_Venta'] ?>" class="btn btn-warning " target="_blank">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
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
            "lengthMenu": [5, 10, 25, 50, "All"],
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            }
        });
    });
</script>