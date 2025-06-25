<?php
include_once("conexion.php");
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$productoEditar = null;

$productos = [];
if (isset($_GET['busqueda']) && $_GET['busqueda'] !== "") {
    $busqueda = $conn->real_escape_string($_GET['busqueda']);
    $sql = "SELECT * FROM productos1 WHERE nombre LIKE '%$busqueda%'";
} else {
    $sql = "SELECT * FROM productos1";
}

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

if (isset($_GET['edit'])) {
    $idEdit = (int) $_GET['edit'];
    foreach ($productos as $p) {
        if ($p['id'] === $idEdit) {
            $productoEditar = $p;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Inicio</title>
</head>

<body>

    <h3>Hola, <?= htmlspecialchars($_SESSION["usuario"]) ?></h3>

    <form method="get" action="">
        <input type="text" name="busqueda" placeholder="Buscar producto por nombre" required>
        <button type="submit">Buscar</button>
        <a href="index.php">Ver todo</a>
    </form>

    <!-- Formulario de Insertar o Editar -->
    <form action="<?= $productoEditar ? 'update.php' : 'insert.php' ?>" method="post">
        <h3><?= $productoEditar ? "Editar Producto" : "Agregar Producto" ?></h3>
        <?php if ($productoEditar): ?>
            <input type="hidden" name="id" value="<?= $productoEditar['id'] ?>">
        <?php endif; ?>
        Nombre: <input type="text" name="nombre"
            value="<?= $productoEditar ? htmlspecialchars($productoEditar['nombre']) : '' ?>" required><br>
        Stock: <input type="number" name="stock" value="<?= $productoEditar ? $productoEditar['stock'] : '' ?>"
            required><br>
        Precio: <input type="number" step="0.01" name="precio"
            value="<?= $productoEditar ? $productoEditar['precio'] : '' ?>" required><br>
        <button type="submit"><?= $productoEditar ? 'Actualizar' : 'Insertar' ?></button>
        <?php if ($productoEditar): ?>
            <a href="index.php">Cancelar</a>
        <?php endif; ?>
    </form>

    <!-- Tabla de productos -->
    <br>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
        <?php if (count($productos) > 0): ?>
            <?php foreach ($productos as $prod): ?>
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
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No se encontraron productos.</td>
            </tr>
        <?php endif; ?>
    </table>

    <br>
    <a href="logout.php">Cerrar sesión</a>

</body>

</html>