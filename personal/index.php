<?php
require '../includes/config.php';
session_start();
if(!isset($_SESSION['personal']) || empty($_SESSION['personal'])) {
  header("Location:". BASE_URL . "login/");
}

$paginaActual = 'Personal';
include '../includes/header.php';
include '../includes/navbar.php';
?>

<?php
$sql = "SELECT * FROM personal";
$result = $conn->query($sql);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Personal</h1>
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
                    <a href="agregarPersonal.php" class="btn btn-default">
                        Nuevo personal
                    </a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Personal Registrado</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Teléfono</th>
                                        <th>Dirección</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['ID_Personal'] ?></td>
                                                <td><?php echo $row['nombre'] ?></td>
                                                <td><?php echo $row['apellido'] ?></td>
                                                <td><?php echo $row['telefono'] ?></td>
                                                <td><?php echo $row['direccion'] ?></td>
                                                <td><?php echo $row['email'] ?></td>
                                                <td><?php echo $row['rol'] ?></td>
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