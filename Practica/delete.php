<?php
include_once("conexion.php");

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $sql = "DELETE FROM productos1 WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: index.php");
        exit();
    }
    echo "Error al eliminar: " . $conn->error;
    exit();
}
header("Location: index.php");
exit();

?>
