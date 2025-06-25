<?php
include_once("conexion.php");
session_start();

if (isset($_POST["usuario"]) && isset($_POST["contrasenia"])) {
    $usuario = $_POST["usuario"];
    $contrasenia = $_POST["contrasenia"];

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasenia = '$contrasenia'";
    $stmt = $conn->query($sql);
    if ($stmt->num_rows > 0) {
        $_SESSION["usuario"] = $usuario;
        header("Location: index.php");
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
} else {
    echo "No se enviaron datos.";
}
?>