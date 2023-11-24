<?php
// Incluir la conexión a la base de datos
require "../config/Conexion.php";

class Clase
{
    // Método para insertar un nuevo registro de clase
    public function insertar($nombre)
    {
        $sql = "INSERT INTO clase (nombre, estado) VALUES ('$nombre', '1')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un registro de clase
    public function editar($idClase, $nombre)
    {
        $sql = "UPDATE clase SET nombre='$nombre' WHERE idClase='$idClase'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar una clase
    public function desactivar($idClase)
    {
        $sql = "UPDATE clase SET estado='0' WHERE idClase='$idClase'";
        return ejecutarConsulta($sql);
    }

    // Método para activar una clase
    public function activar($idClase)
    {
        $sql = "UPDATE clase SET estado='1' WHERE idClase='$idClase'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar un registro de clase
    public function mostrar($idClase)
    {
        $sql = "SELECT * FROM clase WHERE idClase='$idClase'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los registros de clases
    public function listar()
    {
        $sql = "SELECT * FROM clase";
        return ejecutarConsulta($sql);
    }

    // Método para obtener una lista de clases activas para usar en un select
    public function select()
    {
        $sql = "SELECT * FROM clase WHERE estado=1";
        return ejecutarConsulta($sql);
    }
}
?>
