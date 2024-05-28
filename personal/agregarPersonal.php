<?php
require '../includes/config.php';
session_start();

$paginaActual = 'Personal';
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
                            <h4 class="card-title">Registrar nuevo personal</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
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
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" id="direccion" name="direccion" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="contrasena">Contraseña</label>
                                    <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="rol">Rol</label>
                                    <select id="rol" name="rol" class="form-control" required>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Ventas">Ventas</option>
                                        <option value="Almacenes">Almacenes</option>
                                    </select>
                                </div>
                                <div class="form-group justify-content-evenly">
                                    <a href="<?php echo BASE_URL; ?>personal/" class="btn btn-default">Volver</a>
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
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    // Consulta SQL preparada para insertar un nuevo registro
    $sql = "INSERT INTO personal (nombre, apellido, telefono, direccion, email, contrasena, rol) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $nombre, $apellido, $telefono, $direccion, $email, $contrasena, $rol);

    if ($stmt->execute() === TRUE) {
?>
        <script>
            Swal.fire({
                title: "Exito!",
                text: "Personal agregado correctamente",
                icon: "success"
            }).then(function() {
                window.location.href = '<?php echo BASE_URL; ?>personal/';
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