<?php
require '../includes/config.php';
require_once '../plugins/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$nombreImagen = "logoFarmacia.jpeg";
$imagenBase64 = "data:image/jpeg;base64," . base64_encode(file_get_contents($nombreImagen));

// Consultar los datos de las ventas
$sql = "SELECT v.*, c.nombre AS nombre_cliente, c.apellido AS apellido_cliente, p.nombre AS nombre_personal, p.apellido AS apellido_personal
        FROM venta v
        JOIN cliente c ON v.ID_Cliente = c.ID_Cliente
        JOIN personal p ON v.ID_Personal = p.ID_Personal";
$result = $conn->query($sql);

// Generar el PDF con la lista de ventas
$html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Ventas</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            font-size: 12px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
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
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="' . $imagenBase64 . '" alt="Logo de la Farmacia">
            <h2>Lista de Ventas</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Cliente</th>
                    <th>Nombre Personal</th>
                    <th>Fecha Venta</th>
                    <th>Total Venta</th>
                </tr>
            </thead>
            <tbody>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['ID_Venta'] . '</td>
                    <td>' . $row['nombre_cliente'] . ' ' . $row['apellido_cliente'] . '</td>
                    <td>' . $row['nombre_personal'] . ' ' . $row['apellido_personal'] . '</td>
                    <td>' . $row['fecha'] . '</td>
                    <td>' . $row['total_Venta'] . '</td>
                </tr>';
    }
}

$html .= '</tbody>
        </table>
        <div class="footer">
            <p>Farmacia Jhessmin | Dirección: Av. Heroes del Chaco esquina Beni | Teléfono: 68542136</p>
        </div>
    </div>
</body>
</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('letter', 'landscape');
$dompdf->render();

$dompdf->stream('lista_ventas.pdf', array('Attachment' => false));

$conn->close();
?>