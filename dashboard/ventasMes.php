<?php
require '../includes/config.php';

$data = [];
for ($i = 1; $i <= 12; $i++) {
    $sql = "SELECT SUM(total_Venta) as total FROM venta WHERE MONTH(fecha) = $i";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $data[] = $row['total'] ? $row['total'] : 0;
}

echo json_encode($data);
?>
