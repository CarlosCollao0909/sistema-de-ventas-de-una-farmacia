<?php
require '../includes/config.php';
session_start();

if (isset($_SESSION['personal'])) {
    $emailSesion = $_SESSION['personal'];
    $query = "SELECT * FROM personal WHERE email = '$emailSesion'";
    $resultado = mysqli_query($conn, $query);
    foreach ($resultado as $personal) {
        $idSesion = $personal['ID_Personal'];
        $nombreSesion = $personal['nombre'];
        $apellidoSesion = $personal['apellido'];
        $emailSesion = $personal['email'];
        $rolSesion = $personal['rol'];
    }
}

// Obtener los datos enviados desde el formulario
$data = json_decode(file_get_contents("php://input"), true);
$cliente = $data['cliente'];
$personal = $idSesion;
$farmacos = $data['farmacos'];

// Inicio de la transacción
$conn->begin_transaction();

try {
    // Insertar datos de la venta en la tabla "venta"
    $sql = "INSERT INTO venta (ID_Cliente, ID_Personal, fecha, total_Venta) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $fecha_venta = date('Y-m-d');
    $total_venta = calcularTotalVenta($farmacos);
    $stmt->bind_param("iisd", $cliente, $personal, $fecha_venta, $total_venta);
    $stmt->execute();
    $id_venta = $conn->insert_id;

    // Insertar datos de los farmacos en la tabla intermedia "detalle_venta"
    $sql = "INSERT INTO detalle_venta (ID_Farmaco, ID_Venta, cantidad, subtotal) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    $sqlUpdateStock = "UPDATE farmaco SET stock = stock - ? WHERE ID_Farmaco = ?";
    $stmtUpdateStock = $conn->prepare($sqlUpdateStock);

    foreach ($farmacos as $farmaco) {
        //verificar el stock del farmaco
        $farmaco_id = $farmaco['id'];
        $cantidad_venta = $farmaco['cantidad'];
        $query = "SELECT stock FROM farmaco WHERE ID_Farmaco = $farmaco_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $stock_actual = $row['stock'];
        if ($stock_actual < $cantidad_venta) {
            echo json_encode(array('error' => 'La cantidad en stock no es suficiente para el fármaco seleccionado.'));
            exit; // Salir del script si hay un error
        }
        
        $subtotal = $farmaco['precio'] * $farmaco['cantidad'];
        $stmt->bind_param("iiid", $farmaco['id'], $id_venta, $farmaco['cantidad'], $subtotal);
        $stmt->execute();

        // Actualizar el stock del fármaco
        $stmtUpdateStock->bind_param("ii", $farmaco['cantidad'], $farmaco['id']);
        $stmtUpdateStock->execute();
    }

    // Confirmar transacción
    $conn->commit();

    // Devolver una respuesta al cliente
    echo json_encode(array('id' => $id_venta, 'message' => 'Venta procesada correctamente'));
} catch (Exception $e) {
    // En caso de error, deshacer la transacción
    $conn->rollback();
    echo json_encode(array('error' => 'Error al procesar la venta: ' . $e->getMessage()));
}

$conn->close();

function calcularTotalVenta($farmacos)
{
    return array_reduce($farmacos, function ($carry, $farmaco) {
        return $carry + ($farmaco['precio'] * $farmaco['cantidad']);
    }, 0);
}
