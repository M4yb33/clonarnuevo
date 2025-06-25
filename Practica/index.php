<?php
include_once("conexion.php");
include_once("select.php");
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php"); 
    exit();
}

$result = $conn->query("SELECT * FROM productos1");
$productos = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

$productoEditar = null;
if (isset($_GET['edit'])) {
    $idEdit = (int) $_GET['edit'];
    foreach ($productos as $p) {
        if ($p['id'] == $idEdit) {
            $productoEditar = $p;
            break;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inicio</title>
</head>
<body>

<?php
if (isset($_SESSION["usuario"])) {
    echo "Hola, " . htmlspecialchars($_SESSION["usuario"]);
} else {
    echo "No has iniciado sesión.";
}
?>

<form action="<?= $productoEditar ? 'update.php' : 'insert.php' ?>" method="post">
    <h3><?= $productoEditar ? "Editar Producto" : "Agregar Producto" ?></h3>
    <?php if ($productoEditar): ?>
        <input type="hidden" name="id" value="<?= $productoEditar['id'] ?>">
    <?php endif; ?>
    Nombre: <input type="text" name="nombre" value="<?= $productoEditar ? htmlspecialchars($productoEditar['nombre']) : '' ?>" required><br>
    Stock: <input type="number" name="stock" value="<?= $productoEditar ? $productoEditar['stock'] : '' ?>" required><br>
    Precio: <input type="number" step="0.01" name="precio" value="<?= $productoEditar ? $productoEditar['precio'] : '' ?>" required><br>
    <button type="submit"><?= $productoEditar ? 'Actualizar' : 'Insertar' ?></button>
    <?php if ($productoEditar): ?>
        <a href="index.php">Cancelar</a>
    <?php endif; ?>
</form>

<br>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Stock</th>
        <th>Precio</th>
        <th>Acciones</th>
    </tr>
    <?php if (count($productos) > 0):
        foreach ($productos as $prod): ?>
            <tr>
                <td><?= $prod['id'] ?></td>
                <td><?= htmlspecialchars($prod['nombre']) ?></td>
                <td><?= $prod['stock'] ?></td>
                <td><?= $prod['precio'] ?></td>
                <td>
                    <a href="index.php?edit=<?= $prod['id'] ?>">Editar</a> |
                    <a href="delete.php?id=<?= $prod['id'] ?>" onclick="return confirm('¿Eliminar producto?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach;
    else: ?>
        <tr><td colspan="5">No hay productos disponibles.</td></tr>
    <?php endif; ?>
</table>

<a href="logout.php">Cerrar sesión</a>

</body>
</html>
