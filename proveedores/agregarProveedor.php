<?php
require '../includes/config.php';
session_start();

$paginaActual = 'Proveedores';
include '../includes/header.php';
include '../includes/navbar.php';
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center mt-3">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">Registrar nuevo proveedor</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="number" step="1" id="telefono" name="telefono" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Dirección</label>
                                    <input type="text" id="direccion" name="direccion" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group justify-content-right">
                                    <a href="<?php echo BASE_URL; ?>clientes/" class="btn btn-default">Volver</a>
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
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];

    // Consulta SQL preparada para insertar un nuevo registro
    $sql = "INSERT INTO proveedor (nombre, telefono, direccion, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $telefono, $direccion, $email);

    if ($stmt->execute() === TRUE) {
?>
        <script>
            Swal.fire({
                title: "Exito!",
                text: "Proveedor agregado correctamente",
                icon: "success"
            }).then(function() {
                window.location.href = '<?php echo BASE_URL; ?>proveedores/';
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