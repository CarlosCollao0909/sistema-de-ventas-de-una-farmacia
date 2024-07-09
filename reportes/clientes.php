<?php
require '../includes/config.php';
require_once '../plugins/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$nombreImagen = "logoFarmacia.jpeg";
$imagenBase64 = "data:image/jpeg;base64," . base64_encode(file_get_contents($nombreImagen));

// Consultar los datos de los clientes
$sql = "SELECT * FROM cliente";
$result = $conn->query($sql);

// Generar el PDF con la lista de clientes
$html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
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
            <h2>Lista de Clientes</h2>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CI/NIT</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['ID_Cliente'] . '</td>
                    <td>' . $row['ci_nit'] . '</td>
                    <td>' . $row['nombre'] . '</td>
                    <td>' . $row['apellido'] . '</td>
                    <td>' . $row['telefono'] . '</td>
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
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();

$dompdf->stream('lista_clientes.pdf', array('Attachment' => false));

$conn->close();
?>