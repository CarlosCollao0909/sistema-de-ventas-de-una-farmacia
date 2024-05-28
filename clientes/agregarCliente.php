<?php
require '../includes/config.php';
session_start();

$paginaActual = 'Clientes';
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
                            <h4 class="card-title">Registrar nuevo cliente</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="ci_nit">CI/NIT</label>
                                    <input type="number" step="1" id="ci_nit" name="ci_nit" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nombre">Apellido</label>
                                    <input type="text" id="apellido" name="apellido" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="number" step="1" id="telefono" name="telefono" class="form-control" required>
                                </div>
                                <div class="form-group justify-content-evenly">
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
<script>
    var ciNitInput = document.getElementById('ci_nit');
    ciNitInput.addEventListener('keypress', function (event) {
        var char = String.fromCharCode(event.which);
        if (char == ',' || char == '.' || char == 'e' || char == 'E') {
            event.preventDefault();
        }
    });
</script>

<?php
include '../includes/footer.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ci_nit = $_POST['ci_nit'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];

    // Consulta SQL preparada para insertar un nuevo registro
    $sql = "INSERT INTO cliente (ci_nit, nombre, apellido, telefono) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $ci_nit, $nombre, $apellido, $telefono);

    if ($stmt->execute() === TRUE) {
?>
        <script>
            Swal.fire({
                title: "Exito!",
                text: "Cliente agregado correctamente",
                icon: "success"
            }).then(function() {
                window.location.href = '<?php echo BASE_URL; ?>clientes';
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