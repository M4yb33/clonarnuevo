<?php
include_once("conexion.php");

$sqlVer="SELECT * FROM productos1";
$stmt = $conn->query($sqlVer);

if ($stmt-> num_rows > 0) {
    while($row = $stmt->fetch_assoc()) {
        $productos[] = $row;
    }
}

return $productos;
?>