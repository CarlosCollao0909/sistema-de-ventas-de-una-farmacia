<?php
require '../includes/config.php';
session_start();

$paginaActual = 'Farmacos';
include '../includes/header.php';
include '../includes/navbar.php';
?>

<?php
$sqlProveedor = "SELECT ID_Proveedor, nombre FROM proveedor";
$resultProveedor = $conn->query($sqlProveedor);

$sqlCategoria = "SELECT ID_Categoria, nombre FROM categoria";
$resultCategoria = $conn->query($sqlCategoria);
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
                            <h4 class="card-title">Registrar nuevo farmaco</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                                </div>
                                <div class="form-group ml-2">
                                    <label for="categoria">Categoría</label>
                                    <div class="row">
                                        <select id="categoria" name="categoria" class="form-control col-10" required>
                                            <?php
                                            if ($resultCategoria->num_rows > 0) {
                                                while ($row = $resultCategoria->fetch_assoc()) {
                                                    echo "<option value='" . $row["ID_Categoria"] . "'>" . $row["nombre"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                        <a href="<?php echo BASE_URL; ?>categorias/agregarCategoria.php" class="btn btn-primary btn-rounded btn-sm mt-1 ml-2"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="form-group ml-2">
                                    <label for="proveedor">Proveedor</label>
                                    <div class="row">
                                        <select id="proveedor" name="proveedor" class="form-control col-10" required>
                                            <?php
                                            if ($resultProveedor->num_rows > 0) {
                                                while ($row = $resultProveedor->fetch_assoc()) {
                                                    echo "<option value='" . $row["ID_Proveedor"] . "'>" . $row["nombre"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                        <a href="<?php echo BASE_URL; ?>proveedores/agregarProveedor.php" class="btn btn-primary btn-rounded btn-sm mt-1 ml-2"><i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="presentacion">Presentación</label>
                                    <select name="presentacion" id="presentacion" class="form-control" required>
                                        <option value="Tableta">Tableta</option>
                                        <option value="Pomada">Pomada</option>
                                        <option value="Jarabe">Jarabe</option>
                                        <option value="Ampolla">Ampolla</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="precio_compra">Precio Unitario Compra</label>
                                    <input type="number" step="0.1" id="precio_compra" name="precio_compra" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="precio_venta">Precio Unitario Venta</label>
                                    <input type="number" step="0.1" id="precio_venta" name="precio_venta" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="stock">Cantidad a Agregar</label>
                                    <input type="number" step="1" id="stock" name="stock" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" required>
                                </div>
                                <div class="form-group justify-content-evenly">
                                    <a href="<?php echo BASE_URL; ?>farmacos/" class="btn btn-default">Volver</a>
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
    var precioCompraInput = document.getElementById('precio_compra');
    var precioVentaInput = document.getElementById('precio_venta');

    precioVentaInput.addEventListener('change', function() {
        var precioCompra = parseFloat(precioCompraInput.value);
        var precioVenta = parseFloat(precioVentaInput.value);

        if (precioVenta <= precioCompra) {
            Swal.fire({
                icon: "warning",
                title: "Alerta!!",
                text: "El precio de venta debe ser mayor al precio de compra",
            }).then(function() {
                precioVentaInput.value = '';
                setTimeout(function() {
                    precioVentaInput.focus();
                }, 100);
            });
        }
    });

    var stockInput = document.getElementById('stock');
    var precioCompraInput = document.getElementById('precio_compra');
    var precioVentaInput = document.getElementById('precio_venta');

    precioCompraInput.addEventListener('keypress', function(event) {
        var char = String.fromCharCode(event.which);
        if (char == 'e' || char == 'E') {
            event.preventDefault();
        }
    });

    precioVentaInput.addEventListener('keypress', function(event) {
        var char = String.fromCharCode(event.which);
        if (char == 'e' || char == 'E') {
            event.preventDefault();
        }
    });

    stockInput.addEventListener('keypress', function(event) {
        var char = String.fromCharCode(event.which);
        if (char == ',' || char == '.' || char == 'e' || char == 'E') {
            event.preventDefault();
        }
    });

    document.getElementById('fecha_vencimiento').addEventListener('change', function() {
        var fechaActual = new Date(Date.now());

        var fechaVencimiento = new Date(this.value);

        // Calcular la fecha límite (5 meses a partir de la fecha actual)
        var fechaLimite = new Date();
        fechaLimite.setMonth(fechaLimite.getMonth() + 5);

        if (fechaVencimiento < fechaActual) {
            Swal.fire({
                icon: "error",
                title: "Alerta!!",
                text: "El farmaco que se desea registrar ya se encuentra vencido.",
            }).then(function() {
                // Limpiar los campos
                document.getElementById('nombre').value = '';
                document.getElementById('precio_compra').value = '';
                document.getElementById('precio_venta').value = '';
                document.getElementById('stock').value = '';
                document.getElementById('fecha_vencimiento').value = '';
                document.getElementById('categoria').value = '';
                document.getElementById('proveedor').value = '';
            });
        } else if (fechaVencimiento < fechaLimite) {
            //alert('El farmaco que se desea registrar vencerá pronto.');
            Swal.fire({
                icon: "warning",
                title: "Alerta!!",
                text: "El farmaco que se desea registrar vencerá pronto.",
            });
        }
    });
</script>


<?php
include '../includes/footer.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio_compra = $_POST['precio_compra'];
    $precio_venta = $_POST['precio_venta'];
    $stock = $_POST['stock'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $presentacion = $_POST['presentacion'];
    $categoria = $_POST['categoria'];
    $proveedor = $_POST['proveedor'];

    // Consulta SQL preparada para insertar un nuevo registro
    $sql = "INSERT INTO farmaco (nombre, precio_compra, precio_venta, stock, fecha_vencimiento, presentacion, ID_Categoria, ID_Proveedor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddissii", $nombre, $precio_compra, $precio_venta, $stock, $fecha_vencimiento, $presentacion, $categoria, $proveedor);

    if ($stmt->execute() === TRUE) {
?>
        <script>
            Swal.fire({
                title: "Exito!",
                text: "Fármaco agregado correctamente",
                icon: "success"
            }).then(function() {
                window.location.href = '<?php echo BASE_URL; ?>farmacos/';
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