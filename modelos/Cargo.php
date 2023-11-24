<?php
// Incluir la conexión a la base de datos
require "../config/Conexion.php";

class Cargo
{
    // Implementamos nuestro constructor
    public function __construct()
    {
    }

    // Método para insertar un nuevo registro de cargo
    public function insertar($idArea, $nombre)
    {
        $sql = "INSERT INTO cargo (idArea, nombre, estado)
                VALUES ('$idArea', '$nombre', '1')";
        return ejecutarConsulta($sql);
    }

    // Método para editar un registro de cargo
    public function editar($idCargo, $idArea, $nombre)
    {
        $sql = "UPDATE cargo SET idArea='$idArea', nombre='$nombre' 
                WHERE idCargo='$idCargo'";
        return ejecutarConsulta($sql);
    }

    // Método para desactivar un cargo
    public function desactivar($idCargo)
    {
        $sql = "UPDATE cargo SET estado='0' WHERE idCargo='$idCargo'";
        return ejecutarConsulta($sql);
    }

    // Método para activar un cargo
    public function activar($idCargo)
    {
        $sql = "UPDATE cargo SET estado='1' WHERE idCargo='$idCargo'";
        return ejecutarConsulta($sql);
    }

    // Método para mostrar un registro de cargo
    public function mostrar($idCargo)
    {
        $sql = "SELECT * FROM cargo WHERE idCargo='$idCargo'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // Método para listar todos los registros de cargos con información de áreas
    public function listar()
    {
        $sql = "SELECT 
                    cargo.idCargo, 
                    cargo.idArea, 
                    area.nombre as area, 
                    cargo.nombre, 
                    cargo.estado, 
                    cargo.created_at, 
                    cargo.updated_at 
                FROM cargo 
                INNER JOIN area ON cargo.idArea=area.idArea";
        return ejecutarConsulta($sql);
    }

    // Método para listar cargos activos
    public function listarActivos()
    {
        $sql = "SELECT 
                    cargo.idCargo,
                    cargo.idArea,
                    area.nombre as area,
                    cargo.nombre
                FROM cargo
                INNER JOIN area ON cargo.idArea=area.idArea
                WHERE cargo.estado='1'";
        return ejecutarConsulta($sql);
    }

    // Implementar un método para listar los cargos activos, su último precio y el stock
    // (vamos a unir con el último registro de la tabla detalle_ingreso)
}
?>
