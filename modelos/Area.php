<?php
// Incluir la conexión a la base de datos
require "../config/Conexion.php";

class Area
{
    // Método para insertar un nuevo registro de área
    public function insertar($nombre)
    {
        $sql = "INSERT INTO area (nombre, estado) VALUES ('$nombre', '1')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un registro de área
    public function editar($idArea, $nombre)
    {
        $sql = "UPDATE area SET nombre='$nombre' WHERE idArea='$idArea'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar un área
    public function desactivar($idArea)
    {
        $sql = "UPDATE area SET estado='0' WHERE idArea='$idArea'";
        return ejecutarConsulta($sql);
    }

    // Método para activar un área
    public function activar($idArea)
    {
        $sql = "UPDATE area SET estado='1' WHERE idArea='$idArea'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar un registro de área
    public function mostrar($idArea)
    {
        $sql = "SELECT * FROM area WHERE idArea='$idArea'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los registros de áreas
    public function listar()
    {
        $sql = "SELECT * FROM area";
        return ejecutarConsulta($sql);
    }

    // Método para obtener una lista de áreas activas para usar en un select
    public function select()
    {
        $sql = "SELECT * FROM area WHERE estado=1";
        return ejecutarConsulta($sql);
    }
}
?>
