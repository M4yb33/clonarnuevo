<?php
include_once("conexion.php");

$nombre = $_POST["nombre"];
$stock = $_POST["stock"];
$precio = $_POST["precio"];
$sql = "INSERT INTO productos1 (nombre,stock, precio) VALUES ('$nombre', '$stock', '$precio')";
if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error al insertar: " . $conn->error;
    }

?>