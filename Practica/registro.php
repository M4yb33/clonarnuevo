<?php
include_once("conexion.php");
session_start();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario']);
    $contrasenia = trim($_POST['contrasenia']);
    $confirmar = trim($_POST['confirmar_contrasenia']);

    if ($usuario == "" || $contrasenia == "" || $confirmar == "") {
        $mensaje = "Por favor complete todos los campos.";
    } else if ($contrasenia != $confirmar) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        $sql = "INSERT INTO usuarios (usuario, contrasenia) VALUES ('$usuario', '$contrasenia')";
        if ($conn->query($sql)) {
            $mensaje = "Usuario registrado con éxito.";
        } else {
            $mensaje = "Error al registrar: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro de Usuario</title>
</head>
<body>

<h2>Registro de Usuario</h2>

<?php if ($mensaje != ""): ?>
    <p><?= $mensaje ?></p>
<?php endif; ?>

<form method="post" action="">
    Usuario: <input type="text" name="usuario" required><br>
    Contraseña: <input type="password" name="contrasenia" required><br>
    Confirmar contraseña: <input type="password" name="confirmar_contrasenia" required><br>
    <button type="submit">Registrar</button>
</form>

<p><a href="login.php">Ir a Login</a></p>

</body>
</html>
