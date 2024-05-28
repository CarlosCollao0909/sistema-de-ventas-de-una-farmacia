<?php
require '../includes/config.php';
require_once '../plugins/dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$nombreImagen = "logoFarmacia.jpeg";
$imagenBase64 = "data:image/jpeg;base64," . base64_encode(file_get_contents($nombreImagen));


if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idVenta = $_GET['id'];

    // Consultar los detalles de la venta
    $sql = "SELECT v.*, c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, c.ci_nit, p.nombre AS nombre_personal, p.apellido AS apellido_personal
            FROM venta v
            JOIN cliente c ON v.ID_Cliente = c.ID_Cliente
            JOIN personal p ON v.ID_Personal = p.ID_Personal
            WHERE v.ID_Venta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idVenta);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $venta = $result->fetch_assoc();
    } else {
        die("Venta no encontrada");
    }

    // Consultar los detalles de los productos vendidos
    $sql = "SELECT f.nombre AS nombre_farmaco, f.precio_Venta AS precio, f.presentacion, dv.cantidad, dv.subtotal
            FROM detalle_venta dv
            JOIN farmaco f ON dv.ID_Farmaco = f.ID_Farmaco
            WHERE dv.ID_Venta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idVenta);
    $stmt->execute();
    $farmacos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Generar el recibo en PDF
    $html = '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Recibo de Venta</title>
        <style>
            body {
                font-family: "Arial", sans-serif;
                font-size: 14px;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .header img {
                max-width: 100px;
                max-height: 100px;
                border-radius: 50%;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                border-radius: 5px;
                overflow: hidden;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            th {
                background-color: #f2f2f2;
                font-weight: bold;
                padding: 10px;
                text-align: left;
            }
            td {
                padding: 10px;
                border-bottom: 1px solid #ddd;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            .text-center {
                text-align: center;
            }
            .text-right {
                text-align: right;
            }
            .footer {
                margin-top: 20px;
                text-align: center;
                font-size: 12px;
                color: #666;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <img src="' . $imagenBase64 . '" alt="Logo de la Farmacia">
                <h2>Recibo de Venta</h2>
            </div>
            <p><strong>ID Venta:</strong> ' . $venta['ID_Venta'] . '</p>
            <p><strong>Personal encargado:</strong> ' . $venta['nombre_personal'] . ' ' . $venta['apellido_personal'] . '</p>
            <p><strong>C.I. / NIT:</strong> ' . $venta['ci_nit'] .'</p>
            <p><strong>Cliente:</strong> ' . $venta['nombre_cliente'] . ' ' . $venta['apellido_cliente'] . '</p>
            <p><strong>Fecha:</strong> ' . $venta['fecha'] . '</p>

            <h3 class="text-center">Detalle de la Venta</h3>
            <table>
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Descripción del Farmaco</th>
                        <th>Precio Unitario (Bs.)</th>
                        <th>Importe (Bs.)</th>
                    </tr>
                </thead>
                <tbody>';

    foreach ($farmacos as $farmaco) {
        $html .= '<tr>
                    <td>' . $farmaco['cantidad'] . '</td>
                    <td>' . $farmaco['nombre_farmaco'] . ' - ' . $farmaco['presentacion'] . '</td>
                    <td>' . number_format($farmaco['precio'], 2) . '</td>
                    <td>' . number_format($farmaco['subtotal'], 2) . '</td>
                </tr>';
    }

    $html .= '</tbody>
            </table>
            <p class="text-right"><strong>Total a Pagar:</strong> Bs. ' . number_format($venta['total_Venta'], 2) . '</p>
            <div class="footer">
                <p>Farmacia Jhessmin | Dirección: Av. Heroes del Chaco esquina Beni | Teléfono: 68542136</p>
            </div>
        </div>
    </body>
    </html>';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('letter', 'portrait');
    $dompdf->render();

    $dompdf->stream('recibo_' . $idVenta . '.pdf', array('Attachment' => false));
} else {
    die("ID de venta no proporcionado");
}

$conn->close();
?>