<?php
require '../includes/config.php';
session_start();
$paginaActual = 'Ventas';
include '../includes/header.php';
include '../includes/navbar.php';
?>

<?php
$sqlFarmaco = "SELECT ID_Farmaco, nombre, precio_Venta, presentacion FROM farmaco";
$resultFarmaco = $conn->query($sqlFarmaco);

$sqlCliente = "SELECT ID_Cliente, nombre, apellido FROM cliente";
$resultCliente = $conn->query($sqlCliente);

?>
<style>
    select {
        width: 50%;
        padding: 4px 10px;
        margin: 4px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input {
        padding: 4px 10px;
        margin: 4px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .cantidad-td{
        width: 20%;
        text-align: center;
    }
    .cantidad-input{
        width: 45%;
        text-align: center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row justify-content-center mt-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Nueva Venta</h3>
                    </div>
                    <div class="card-body">
                        <form id="venta-form">
                            <h2 class="text-center">Venta de Farmacos</h2>

                            <div class="form-group">
                                <label for="personal">Personal:</label>
                                <input type="text" id="personal" name="personal" value="<?php echo $nombreSesion . ' ' . $apellidoSesion; ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="cliente">Cliente:</label>
                                <select name="cliente" id="cliente" required>
                                    <option value="">Selecciona un cliente</option>
                                    <?php
                                    if ($resultCliente->num_rows > 0) {
                                        while ($row = $resultCliente->fetch_assoc()) {
                                            echo '<option value="' . $row['ID_Cliente'] . '">' . $row['nombre'] . ' ' . $row['apellido'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <a href="<?php echo BASE_URL; ?>clientes/agregarCliente.php" class="btn btn-primary btn-rounded btn-sm"><i class="fas fa-plus"></i></a>
                            </div>

                            <div class="form-group">
                                <label for="fecha">Fecha:</label>
                                <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="farmaco">Farmaco:</label>
                                <select id="farmaco" name="farmaco" class="select2">
                                    <option value="">Selecciona un farmaco</option>
                                    <?php
                                    if ($resultFarmaco->num_rows > 0) {
                                        while ($row = $resultFarmaco->fetch_assoc()) {
                                            echo '<option value="' . $row['ID_Farmaco'] . '" data-precio="' . $row['precio_Venta'] . '">' . $row['nombre'] . ' - '. $row['presentacion'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad" min="1">
                                <button type="button" class="btn btn-primary" onclick="agregarFarmaco()">Agregar</button>
                            </div>



                            <table id="farmaco-table" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Descripción Farmaco</th>
                                        <th>Precio Unitario (Bs.)</th>
                                        <th>Importe (Bs.)</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                            <div class="form-group text-right">
                                <label> <b>Total:</b> </label>
                                <span id="subtotal">0.00</span>
                            </div>

                            <button type="submit" class="btn btn-success">Finalizar Venta</button>
                        </form>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
</div>
<!-- /.content-wrapper -->
<script>
    let farmacos = [];

    function agregarFarmaco() {
        const farmacoSelect = document.getElementById('farmaco');
        const cantidadInput = document.getElementById('cantidad');

        const farmacoId = farmacoSelect.value;
        const farmacoCantidad = cantidadInput.value;
        const farmacoPrecio = Number(farmacoSelect.options[farmacoSelect.selectedIndex].dataset.precio);

        if (farmacoId && farmacoCantidad) {
            const farmaco = {
                id: farmacoId,
                cantidad: farmacoCantidad,
                precio: farmacoPrecio
            };
            farmacos.push(farmaco);
            actualizarTabla();
            farmacoSelect.value = '';
            cantidadInput.value = '';
        }
    }

    function actualizarTabla() {
        const tbody = document.getElementById('farmaco-table').getElementsByTagName('tbody')[0];
        tbody.innerHTML = '';

        let total = 0;
        farmacos.forEach((farmaco, index) => {
            const row = document.createElement('tr');

            const cantidadCell = document.createElement('td');
            cantidadCell.classList.add('cantidad-td');
            const cantidadInput = document.createElement('input');
            cantidadInput.type = 'number';
            cantidadInput.value = farmaco.cantidad;
            cantidadInput.min = 1;
            cantidadInput.classList.add('cantidad-input');
            cantidadInput.onchange = () => actualizarCantidad(index, cantidadInput.value);
            cantidadCell.appendChild(cantidadInput);
            row.appendChild(cantidadCell);

            const farmacoCell = document.createElement('td');
            farmacoCell.textContent = document.querySelector(`#farmaco option[value="${farmaco.id}"]`).textContent;
            row.appendChild(farmacoCell);

            const precioUnitarioCell = document.createElement('td');
            precioUnitarioCell.textContent = farmaco.precio.toFixed(2);
            row.appendChild(precioUnitarioCell);

            const precioCell = document.createElement('td');
            const subtotal = farmaco.precio * farmaco.cantidad;
            precioCell.textContent = subtotal.toFixed(2);
            total += subtotal;
            row.appendChild(precioCell);

            const accionCell = document.createElement('td');
            const eliminarButton = document.createElement('button');
            eliminarButton.textContent = 'Eliminar';
            eliminarButton.onclick = () => eliminarFarmaco(index);
            eliminarButton.classList.add('btn', 'btn-danger');
            accionCell.appendChild(eliminarButton);
            row.appendChild(accionCell);

            tbody.appendChild(row);
        });

        document.getElementById('subtotal').textContent = total.toFixed(2);
    }

    function actualizarCantidad(index, nuevaCantidad) {
        if (nuevaCantidad > 0) {
            farmacos[index].cantidad = nuevaCantidad;
            actualizarTabla();
        }
    }

    function eliminarFarmaco(index) {
        farmacos.splice(index, 1);
        actualizarTabla();
    }

    document.getElementById('venta-form').addEventListener('submit', (event) => {
        event.preventDefault();
        const cliente = document.getElementById('cliente').value;
        const personal = document.getElementById('personal').value;

        if (farmacos.length === 0) {
            Swal.fire({
                title: "Error!",
                text: "Debe agregar al menos un farmaco",
                icon: "error"
            });
            return;
        }

        // Crear un objeto con los datos de la venta
        const ventaData = {
            cliente: cliente,
            personal: personal,
            farmacos: farmacos
        };

        // Enviar los datos al servidor utilizando Fetch
        fetch('procesar_venta.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(ventaData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    Swal.fire({
                        title: "Error!",
                        text: "El stock de uno de los farmacos agregados no es suficiente",
                        icon: "error"
                    })
                } else {
                    console.log('Venta realizada:', data);
                    Swal.fire({
                        title: "Exito!",
                        text: "Venta realizada correctamente",
                        icon: "success"
                    }).then(function() {
                        // Abrir recibo de la venta
                        window.open('<?php echo BASE_URL; ?>ventas/recibo.php?id=' + data.id, '_blank');
                        // Redireccionar al listado de ventas
                        window.location.href = '<?php echo BASE_URL; ?>ventas/';
                    });
                }
            })
            .catch(error => {
                console.error('Error al procesar la venta:', error);
                // Aquí puedes agregar código para mostrar un mensaje de error
            });
    });
</script>

<?php
include '../includes/footer.php';
?>
<script>
    $(function(){
        $('.select2').select2();
    })
</script>