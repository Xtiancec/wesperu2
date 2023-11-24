<?php
// Incluir la conexión a la base de datos
require "../config/Conexion.php";

class Almacen
{
    // Método para insertar un nuevo registro de almacén
    public function insertar($nombre, $direccion)
    {
        $sql = "INSERT INTO almacenes (nombre, direccion, estado) VALUES ('$nombre', '$direccion', '1')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un registro de almacén
    public function editar($idAlmacen, $nombre, $direccion)
    {
        $sql = "UPDATE almacenes SET nombre='$nombre', direccion='$direccion' WHERE idAlmacen='$idAlmacen'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar un almacén
    public function desactivar($idAlmacen)
    {
        $sql = "UPDATE almacenes SET estado='0' WHERE idAlmacen='$idAlmacen'";
        return ejecutarConsulta($sql);
    }

    // Método para activar un almacén
    public function activar($idAlmacen)
    {
        $sql = "UPDATE almacenes SET estado='1' WHERE idAlmacen='$idAlmacen'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar un registro de almacén
    public function mostrar($idAlmacen)
    {
        $sql = "SELECT * FROM almacenes WHERE idAlmacen='$idAlmacen'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los almacenes
    public function listar()
    {
        $sql = "SELECT * FROM almacenes";
        return ejecutarConsulta($sql);
    }

    // Método para obtener una lista de almacenes activos para usar en un select
    public function select()
    {
        $sql = "SELECT idAlmacen, nombre FROM almacenes WHERE estado=1";
        return ejecutarConsulta($sql);
    }
}
?>
