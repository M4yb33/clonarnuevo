<?php
include 'conexion.php';
include 'usuarioCrud.php';

$error = '';
$exito = '';
$usuarioCrud = new UsuarioCrud($conn);

// Si ya está logueado, ir al inicio
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Procesar registro
if ($_POST) {
    $usuario = $_POST['usuario'];
    $contra = $_POST['contra'];
    $confirmar_contra = $_POST['confirmar_contra'];

    if (!empty($usuario) && !empty($contra) && !empty($confirmar_contra)) {
        if ($contra !== $confirmar_contra) {
            $error = 'Las contraseñas no coinciden';
        } elseif ($usuarioCrud->existeUsuario($usuario)) {
            $error = 'El usuario ya existe';
        } else {
            if ($usuarioCrud->registrar($usuario, $contra)) {
                $exito = 'Usuario registrado correctamente. Ya puedes iniciar sesión.';
            } else {
                $error = 'Error al registrar usuario';
            }
        }
    } else {
        $error = 'Por favor complete todos los campos';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php if ($exito): ?>
        <p><?php echo $exito; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <p>Usuario: <input type="text" name="usuario" required></p>
        <p>Contraseña: <input type="password" name="contra" required></p>
        <p>Confirmar Contraseña: <input type="password" name="confirmar_contra" required></p>
        <p><button type="submit">Registrarse</button></p>
    </form>
    
    <p><a href="login.php">Inicia sesión aquí</a></p>
</body>
</html>