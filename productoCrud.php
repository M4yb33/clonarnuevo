<?php
class ProductoCrud
{
    private $conn;

    public function __construct($conexion)
    {
        $this->conn = $conexion;
    }
    public function agregar($nombre, $stock, $precio)
    {
        $sql = "INSERT INTO productos1 (nombre, stock, precio) VALUES ('$nombre', '$stock', '$precio')";
        return $this->conn->query($sql);
    }

    public function obtenerTodos()
    {
        $sql = "SELECT * FROM productos1";
        return $this->conn->query($sql);
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM productos1 WHERE id = '$id'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function editar($id, $nombre, $stock, $precio)
    {
        $sql = "UPDATE productos1 SET nombre = '$nombre', stock = '$stock', precio = '$precio' WHERE id = '$id'";
        return $this->conn->query($sql);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM productos1 WHERE id = '$id'";
        return $this->conn->query($sql);
    }
}
?>