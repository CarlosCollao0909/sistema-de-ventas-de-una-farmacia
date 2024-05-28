<?php
require '../includes/config.php';
session_start();
if(!isset($_SESSION['personal']) || empty($_SESSION['personal'])) {
  header("Location:". BASE_URL . "login/");
}

$paginaActual = 'Farmacos';
include '../includes/header.php';
include '../includes/navbar.php';
?>

<?php
$sql = "SELECT f.*, f.nombre AS nombre_farmaco, p.nombre AS nombre_proveedor, c.nombre AS nombre_categoria
        FROM farmaco f
        JOIN proveedor p ON f.ID_Proveedor = p.ID_Proveedor
        JOIN categoria c ON f.ID_Categoria = c.ID_Categoria";
$result = $conn->query($sql);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Fármacos</h1>
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
                    <a href="agregarFarmaco.php" class="btn btn-default">
                        Nuevo fármaco
                    </a>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Fármacos Registrados</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="table2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Presentación</th>
                                        <th>Precio Unitario Venta</th>
                                        <th>Stock</th>
                                        <th>Fecha de Vencimiento</th>
                                        <th>Categoría</th>
                                        <th>Proveedor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                            <tr>
                                                <td><?php echo $row['ID_Farmaco'] ?></td>
                                                <td><?php echo $row['nombre'] ?></td>
                                                <td><?php echo $row['presentacion'] ?></td>
                                                <td><?php echo $row['precio_Venta'] ?></td>
                                                <td><?php echo $row['stock'] ?></td>
                                                <td><?php echo $row['fecha_vencimiento'] ?></td>
                                                <td><?php echo $row['nombre_categoria'] ?></td>
                                                <td><?php echo $row['nombre_proveedor'] ?></td>
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