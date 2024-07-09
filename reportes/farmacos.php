<?php
require '../includes/config.php';
require_once '../plugins/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$nombreImagen = "logoFarmacia.jpeg";
$imagenBase64 = "data:image/jpeg;base64," . base64_encode(file_get_contents($nombreImagen));

// Consultar los datos de los fármacos
$sql = "SELECT f.*, f.nombre AS nombre_farmaco, p.nombre AS nombre_proveedor, c.nombre AS nombre_categoria
        FROM farmaco f
        JOIN proveedor p ON f.ID_Proveedor = p.ID_Proveedor
        JOIN categoria c ON f.ID_Categoria = c.ID_Categoria";
$result = $conn->query($sql);

// Generar el PDF con la lista de fármacos
$html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Fármacos</title>
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
            <h2>Lista de Fármacos</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Presentación</th>
                    <th>Precio Venta</th>
                    <th>Stock</th>
                    <th>Fecha Vencimiento</th>
                    <th>Categoría</th>
                    <th>Proveedor</th>
                </tr>
            </thead>
            <tbody>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['ID_Farmaco'] . '</td>
                    <td>' . $row['nombre'] . '</td>
                    <td>' . $row['presentacion'] . '</td>
                    <td>' . $row['precio_Venta'] . '</td>
                    <td>' . $row['stock'] . '</td>
                    <td>' . $row['fecha_vencimiento'] . '</td>
                    <td>' . $row['nombre_categoria'] . '</td>
                    <td>' . $row['nombre_proveedor'] . '</td>
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

$dompdf->stream('lista_farmacos.pdf', array('Attachment' => false));

$conn->close();
?>