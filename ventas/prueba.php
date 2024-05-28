<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Ventas - Farmacia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-group {
            margin-bottom: 1rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.5rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <h1>Sistema de Ventas - Farmacia</h1>
        <form id="venta-form">
            <h2>Venta de Farmacia</h2>

            <div class="form-group">
                <label for="cliente">Cliente:</label>
                <input type="text" id="cliente" name="cliente" required>
            </div>

            <div class="form-group">
                <label for="personal">Personal:</label>
                <select id="personal" name="personal" required>
                    <option value="">Selecciona un personal</option>
                    <!-- Aquí deberías cargar las opciones desde la base de datos -->
                    <option value="1">Juan Pérez</option>
                    <option value="2">María González</option>
                    <option value="3">Carlos Ramírez</option>
                </select>
            </div>

            <div class="form-group">
                <label for="farmaco">Farmaco:</label>
                <select id="farmaco" name="farmaco" required>
                    <option value="">Selecciona un farmaco</option>
                    <!-- Aquí deberías cargar las opciones desde la base de datos -->
                    <option value="1" data-precio="10.00">Aspirina</option>
                    <option value="2" data-precio="15.00">Paracetamol</option>
                    <option value="3" data-precio="20.00">Ibuprofeno</option>
                </select>
                <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad" min="1" required>
                <button type="button" class="btn btn-primary" onclick="agregarFarmaco()">Agregar</button>
            </div>

            

            <table id="farmaco-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Farmaco</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <div class="form-group text-right">
                <label for="subtotal"> <b>Total:</b> </label>
                <span id="subtotal">0.00</span>
            </div>

            <button type="submit" class="btn btn-success">Finalizar Venta</button>
        </form>
    </div>

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

                const farmacoCell = document.createElement('td');
                farmacoCell.textContent = document.querySelector(`#farmaco option[value="${farmaco.id}"]`).textContent;
                row.appendChild(farmacoCell);

                const cantidadCell = document.createElement('td');
                cantidadCell.textContent = farmaco.cantidad;
                row.appendChild(cantidadCell);

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

        function eliminarFarmaco(index) {
            farmacos.splice(index, 1);
            actualizarTabla();
        }

        document.getElementById('venta-form').addEventListener('submit', (event) => {
            event.preventDefault();
            const cliente = document.getElementById('cliente').value;
            const personal = document.getElementById('personal').value;

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
                    console.log('Venta realizada:', data);
                    // Aquí puedes agregar código para limpiar el formulario o mostrar un mensaje de éxito
                })
                .catch(error => {
                    console.error('Error al procesar la venta:', error);
                    // Aquí puedes agregar código para mostrar un mensaje de error
                });
        });
    </script>
</body>

</html>