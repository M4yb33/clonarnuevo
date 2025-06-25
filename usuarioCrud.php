<?php
class UsuarioCrud
{
    private $conn;

    public function __construct($conexion)
    {
        $this->conn = $conexion;
    }

    public function validarLogin($usuario, $contra)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contra = '$contra'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }

    public function existeUsuario($usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $result = $this->conn->query($sql);
        return $result->num_rows > 0;
    }

    public function registrar($usuario, $contra)
    {
        $sql = "INSERT INTO usuarios (usuario, contra) VALUES ('$usuario', '$contra')";
        return $this->conn->query($sql);
    }
}
?>