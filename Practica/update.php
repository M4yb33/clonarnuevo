<?php
include_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id'], $_POST['nombre'], $_POST['stock'], $_POST['precio'])) {
        $id = (int) $_POST['id'];
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $stock = (int) $_POST['stock'];
        $precio = (float) $_POST['precio'];

        $sql = "UPDATE productos1 SET nombre='$nombre', stock=$stock, precio=$precio WHERE id=$id";

        if ($conn->query($sql)) {
            header("Location: index.php");
            exit();
        }
        echo "Error al actualizar: " . $conn->error;
        exit();
    }
    echo "Faltan datos para actualizar.";
    exit();
}
header("Location: index.php");
exit();
?>