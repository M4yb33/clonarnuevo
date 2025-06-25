<?php
include_once 'conexion.php';
include_once 'usuarioCrud.php';

$error = '';
$usuarioCrud = new UsuarioCrud($conn);

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

if ($_POST) {
    $usuario = $_POST['usuario'];
    $contra = $_POST['contra'];

    $user = $usuarioCrud->validarLogin($usuario, $contra);

    if ($user) {
        $_SESSION['usuario'] = $user['usuario'];
        header('Location: index.php');
        exit();
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Iniciar Sesión</h2>

    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <p>Usuario: <input type="text" name="usuario" required></p>
        <p>Contraseña: <input type="password" name="contra" required></p>
        <p><button type="submit">Entrar</button></p>
    </form>

</body>

</html>