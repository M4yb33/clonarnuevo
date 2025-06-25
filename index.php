<?php
include 'conexion.php';
include 'productoCrud.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$mensaje = '';
$editando = false;
$producto_editar = null;
$productoCrud = new ProductoCrud($conn);

if (isset($_GET['editar'])) {
    $editando = true;
    $id = $_GET['editar'];
    $producto_editar = $productoCrud->obtenerPorId($id);
}

if ($_POST && isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];

    if (!empty($nombre) && !empty($stock) && !empty($precio)) {
        if ($productoCrud->agregar($nombre, $stock, $precio)) {
            $mensaje = 'Producto agregado correctamente';
        } else {
            $mensaje = 'Error al agregar producto';
        }
    }
}

if ($_POST && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];

    if (!empty($nombre) && !empty($stock) && !empty($precio)) {
        if ($productoCrud->editar($id, $nombre, $stock, $precio)) {
            $mensaje = 'Producto editado correctamente';
            header('Location: index.php');
            exit();
        } else {
            $mensaje = 'Error al editar producto';
        }
    }
}

if ($_POST && isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    if ($productoCrud->eliminar($id)) {
        $mensaje = 'Producto eliminado correctamente';
    } else {
        $mensaje = 'Error al eliminar producto';
    }
}

$productos = $productoCrud->obtenerTodos();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Inicio</title>
</head>

<body>
    <h2>Bienvenido: <?php echo $_SESSION['usuario']; ?></h2>
    <p><a href="logout.php">Salir</a></p>

    <h3><?php echo $editando ? 'Editar Producto' : 'Agregar Producto'; ?></h3>

    <?php if ($mensaje): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form method="POST">
        <?php if ($editando): ?>
            <input type="hidden" name="id" value="<?php echo $producto_editar['id']; ?>">
        <?php endif; ?>

        <p>Nombre: <input type="text" name="nombre" value="<?php echo $editando ? $producto_editar['nombre'] : ''; ?>"
                required></p>
        <p>Stock: <input type="number" name="stock" value="<?php echo $editando ? $producto_editar['stock'] : ''; ?>"
                required></p>
        <p>Precio: <input type="number" name="precio" value="<?php echo $editando ? $producto_editar['precio'] : ''; ?>"
                step="0.01" required></p>
        <p>
            <button type="submit" name="<?php echo $editando ? 'editar' : 'agregar'; ?>">
                <?php echo $editando ? 'Editar' : 'Agregar'; ?>
            </button>
            <?php if ($editando): ?>
                <a href="index.php">Cancelar</a>
            <?php endif; ?>
        </p>
    </form>

    <h3>Lista de Productos</h3>

    <?php if ($productos->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = $productos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>$<?php echo number_format($row['precio'], 2); ?></td>
                    <td>
                        <a href="index.php?editar=<?php echo $row['id']; ?>">Editar</a> |
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="eliminar" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No hay productos registrados</p>
    <?php endif; ?>
</body>

</html>