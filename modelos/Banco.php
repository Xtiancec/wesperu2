<?php
// Incluir la conexión a la base de datos
require "../config/Conexion.php";

class Banco
{
    // Método para insertar un nuevo registro de banco
    public function insertar($nombre, $tipoBanco)
    {
        $sql = "INSERT INTO banco (nombre, tipoBanco, estado) VALUES ('$nombre', '$tipoBanco', '1')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un registro de banco
    public function editar($idBanco, $nombre, $tipoBanco)
    {
        $sql = "UPDATE banco SET nombre='$nombre', tipoBanco='$tipoBanco' WHERE idBanco='$idBanco'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar un banco
    public function desactivar($idBanco)
    {
        $sql = "UPDATE banco SET estado='0' WHERE idBanco='$idBanco'";
        return ejecutarConsulta($sql);
    }

    // Método para activar un banco
    public function activar($idBanco)
    {
        $sql = "UPDATE banco SET estado='1' WHERE idBanco='$idBanco'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar un registro de banco
    public function mostrar($idBanco)
    {
        $sql = "SELECT * FROM banco WHERE idBanco='$idBanco'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los registros de bancos
    public function listar()
    {
        $sql = "SELECT * FROM banco";
        return ejecutarConsulta($sql);
    }

    // Método para obtener una lista de bancos activos para usar en un select
    public function select()
    {
        $sql = "SELECT * FROM banco WHERE estado=1";
        return ejecutarConsulta($sql);
    }
}
?>
