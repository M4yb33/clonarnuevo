<?php
class UsuarioCrud {
    private $conn;
    
    public function __construct($conexion) {
        $this->conn = $conexion;
    }
    
    public function validarLogin($usuario, $contra) {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contra = '$contra'";
        $result = $this->conn->query($sql);
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
}
?>