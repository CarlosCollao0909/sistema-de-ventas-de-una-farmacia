<?php
require '../includes/config.php';
session_start();

$paginaActual = 'Categorias';
include '../includes/header.php';
include '../includes/navbar.php';
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">Registrar nueva categoría</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Descripción</label>
                                    <input type="text" id="descripcion" name="descripcion" class="form-control" required>
                                </div>
                                <div class="form-group justify-content-evenly">
                                    <a href="<?php echo BASE_URL; ?>categorias/" class="btn btn-default">Volver</a>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Consulta SQL preparada para insertar un nuevo registro
    $sql = "INSERT INTO categoria (nombre, descripcion) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $descripcion);

    if ($stmt->execute() === TRUE) {
?>
        <script>
            Swal.fire({
                title: "Exito!",
                text: "Categoría agregada correctamente",
                icon: "success"
            }).then(function() {
                window.location.href = '<?php echo BASE_URL; ?>categorias/';
            });
        </script>
<?php
    } else {
?>
        <script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "<?php echo $stmt->error; ?>",
            });
        </script>
<?php
    }


    // Cerrar conexión
    $stmt->close();
    $conn->close();
}

?>