<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Requerimiento
{
    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //metodo insertar registro
    public function insertar(
        $idOT,
        $idUsuario,
        $idTipoSalida,
        $correlativo,
        $fecha,
        $idExistencia,
        $stockSolicitado
    ) {
        $sql = "INSERT INTO requerimiento 
    (
    idOT,
    idUsuario,
    idTipoSalida,
    correlativo,
    fecha,
    estado) 
    VALUES 
    (
    '$idOT',
    '$idUsuario',
    '$idTipoSalida',
    '$correlativo',
    '$fecha',
    'Pendiente de Aprobación')";


        //return ejecutarConsulta($sql);
        $idingresonew = ejecutarConsulta_retornarID($sql);
        $num_elementos = 0;
        $sw = true;

        while ($num_elementos < count($idExistencia)) {
            $sql_detalle = "INSERT INTO detallerequerimiento(idRequerimiento,idExistencia,stockSolicitado)
        VALUES('$idingresonew','$idExistencia[$num_elementos]','$stockSolicitado[$num_elementos]');";




            ejecutarConsulta($sql_detalle) or $sw = false;

            $num_elementos = $num_elementos + 1;
        }
        return $sw;
    }

    public function anular($idRequerimiento)
    {
        $sql = "UPDATE requerimiento SET estado='Anulado' WHERE idRequerimiento='$idRequerimiento'";
        return ejecutarConsulta($sql);
    }




    //metodo para mostrar registros
    public function mostrar($idRequerimiento)
    {
        $sql = "SELECT 
        requerimiento.idRequerimiento,
        ordentrabajo.numero,
        usuario.login,
        tipo_salida.nombre,
        requerimiento.correlativo,
        requerimiento.fecha,
        requerimiento.estado
        
        FROM requerimiento
        INNER JOIN ordentrabajo on ordentrabajo.idOT=requerimiento.idOT
        INNER JOIN usuario on usuario.idUsuario=requerimiento.idUsuario
        INNER JOIN tipo_salida on tipo_salida.idTiposalida=requerimiento.idTipoSalida
        
      
    WHERE idRequerimiento='$idRequerimiento'";
        return ejecutarConsultaSimpleFila($sql);
    }



    public function listarDetalle($idRequerimiento)
    {
        $sql = "SELECT 
        detallerequerimiento.idDetalleRequerimiento,
        requerimiento.correlativo,
        existencia.nombre,
        detallerequerimiento.stockSolicitado
        
        FROM detallerequerimiento
        
        INNER JOIN requerimiento on requerimiento.idRequerimiento=detallerequerimiento.idRequerimiento
        INNER JOIN existencia on existencia.idExistencia=detallerequerimiento.idExistencia
         WHERE detallerequerimiento.idRequerimiento='$idRequerimiento'";

        return ejecutarConsulta($sql);
    }


    //listar registros
    public function listar()
    {
        $sql = "SELECT 
        requerimiento.idRequerimiento,
        ordentrabajo.numero as ot,
        usuario.login as usuario,
        tipo_salida.nombre as tipoSalida,
        requerimiento.correlativo,
        requerimiento.fecha,
        requerimiento.estado
        
        FROM requerimiento
        INNER JOIN ordentrabajo on ordentrabajo.idOT=requerimiento.idOT
        INNER JOIN usuario on usuario.idUsuario=requerimiento.idUsuario
        INNER JOIN tipo_salida on tipo_salida.idTiposalida=requerimiento.idTipoSalida
         ORDER BY requerimiento.idRequerimiento DESC";
        return ejecutarConsulta($sql);
    }
}
