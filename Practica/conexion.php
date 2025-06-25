<?php
$server= "localhost";
$user="root";
$password = "";
$db = "pruebavs";

$conn = mysqli_connect($server,$user,$password,$db);
if ($conn -> connect_error) {
    die("Conexion fallida" + $conn);
}

?>