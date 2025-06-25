<?php
include_once("conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="crudUsuario.php" method="post">
        <p>Usuario
            <input type="text" id="usuario" name="usuario">
        </p>
        <p>Contraseña
            <input type="password" id="contrasenia" name="contrasenia">
        </p>
        <button type="submit">Ingresar</button>
    </form>
    <form action="registro.php" method="get">
    <button type="submit">Registrarse</button>
</form>

</body>
</html>

