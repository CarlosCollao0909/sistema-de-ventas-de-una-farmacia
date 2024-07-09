<h6>Selecciona una Fecha para Ver las Ventas</h6>
              <form method="POST" action="">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>
                <input type="submit" value="Ver Ventas">
              </form>
              <?php
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $fecha = $_POST['fecha'];
                mostrarReporteDeVentas($fecha);
              }

              function mostrarReporteDeVentas($fecha){
                $servername = "localhost";
                $username = "root";
                $password = ""; 
                $dbname = "db_farmacia"; 

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                  die("Conexión fallida: " . $conn->connect_error);
                }

                // Consulta SQL para obtener el total de ventas del día
                $sql_total_ventas = "SELECT SUM(total_Venta) AS total_ventas_dia FROM venta WHERE fecha = ?";
                $stmt_total_ventas = $conn->prepare($sql_total_ventas);
                $stmt_total_ventas->bind_param("s", $fecha);
                $stmt_total_ventas->execute();
                $result_total_ventas = $stmt_total_ventas->get_result();

                // Mostrar el total de ventas del día
                if ($result_total_ventas->num_rows > 0) {
                  $row_total = $result_total_ventas->fetch_assoc();
                } else {
                  echo "<h6 class='text-center'>No se encontraron ventas para la fecha seleccionada.</h6>";
                }

                // Consulta SQL para obtener los fármacos vendidos agrupados por nombre
                $sql = "
                  SELECT farmaco.nombre AS nombre_farmaco, SUM(detalle_venta.cantidad) AS cantidad_total, SUM(detalle_venta.subtotal) AS subtotal_total 
                  FROM venta 
                  JOIN detalle_venta ON venta.ID_Venta = detalle_venta.ID_Venta 
                  JOIN farmaco ON detalle_venta.ID_Farmaco = farmaco.ID_Farmaco 
                  WHERE venta.fecha = ?
                  GROUP BY farmaco.nombre
                ";

                // Preparar y ejecutar la consulta
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $fecha);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                  echo "<table class='table table-bordered table-hover'>";
                  echo "<tr><th>Nombre del Fármaco</th><th>Cantidad Vendida</th><th>Subtotal</th></tr>";
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre_farmaco"] . "</td>";
                    echo "<td>" . $row["cantidad_total"] . "</td>";
                    echo "<td>$" . number_format($row["subtotal_total"], 2) . "</td>";
                    echo "</tr>";
                  }
                  echo "</table>";
                  
                  echo "<h6 class='mt-3 text-right'>Total de Ventas del $fecha: <br> <b> Bs. " . number_format($row_total["total_ventas_dia"], 2) . "</b> </h6>";
                } else {
                  echo "<p>No hay detalles de ventas para la fecha seleccionada.</p>";
                }

                // Cerrar las conexiones
                $stmt->close();
                $stmt_total_ventas->close();
                $conn->close();
              }
              ?>