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
        $stockSolicitado,
        $estado
    ) {
        $autorizaciones = $this->obtenerAutorizacionesExistencias($idExistencia);

        // Determinar el estado en función de las autorizaciones
        if (in_array('si', $autorizaciones)) {
            $estado = 'Pendiente de Autorización';
        } else {
            $estado = 'Pendiente';
        }
        // Crear la consulta SQL para insertar un nuevo requerimiento
        $sql = "INSERT INTO requerimiento (idOT, idUsuario, idTipoSalida, correlativo, fecha, estado) VALUES ('$idOT', '$idUsuario', '$idTipoSalida', '$correlativo', '$fecha', '$estado')";
        $idingresonew = ejecutarConsulta_retornarID($sql);

        if ($idingresonew) {
            // Ahora puedes proceder a insertar en la tabla detallerequerimiento
            $num_elementos = 0;
            $sw = true;

            while ($num_elementos < count($idExistencia)) {
                $sql_detalle = "INSERT INTO detallerequerimiento (idRequerimiento, idExistencia, stockSolicitado) VALUES ('$idingresonew', '$idExistencia[$num_elementos]', '$stockSolicitado[$num_elementos]')";
                ejecutarConsulta($sql_detalle) or $sw = false;

                $num_elementos++;
            }

            // Verificar el resultado final
            if ($sw) {
                echo "Datos registrados correctamente";
            } else {
                echo "No se pudo registrar los datos en detallerequerimiento";
            }
        } else {
            echo "No se pudo registrar los datos en requerimiento";
        }
    }

    public function obtenerAutorizacionesExistencias($idExistencia)
    {
        // Consulta SQL para obtener la autorización de las existencias seleccionadas
        $sql = "SELECT autorizacion FROM existencia WHERE idExistencia IN (" . implode(",", $idExistencia) . ")";
        $resultado = ejecutarConsulta($sql);

        $autorizaciones = array();

        while ($reg = $resultado->fetch_object()) {
            $autorizaciones[] = $reg->autorizacion;
        }

        return $autorizaciones;
    }

    public function anular($idRequerimiento)
    {
        // Crear la consulta SQL para actualizar el estado del requerimiento a 'Anulado'
        $sql = "UPDATE requerimiento SET estado='Anulado' WHERE idRequerimiento='$idRequerimiento'";
        // Ejecutar la consulta y devolver el resultado
        return ejecutarConsulta($sql);
    }



    public function obtenerUltimaSecuenciaPorTipoSalida($idTipoSalida)
    {
        $sql = "SELECT MAX(SUBSTRING(correlativo, 2)) AS ultimaSecuencia FROM requerimiento WHERE idTipoSalida = '$idTipoSalida'";
        $resultado = ejecutarConsultaSimpleFila($sql); // Debes implementar esta función

        if ($resultado && $resultado['ultimaSecuencia'] !== null) {
            return intval($resultado['ultimaSecuencia']);
        } else {
            return 0; // Si no hay registros, devolver 0 como última secuencia
        }
    }
    public function obtenerLetraTipoSalida($idTipoSalida)
    {
        $sql = "SELECT SUBSTRING(nombre,1,1) as letra FROM tipo_salida WHERE idTipoSalida = '$idTipoSalida'";
        $resultado = ejecutarConsultaSimpleFila($sql); // Debes implementar esta función

        if ($resultado) {
            return $resultado['letra'];
        } else {
            return ''; // Retorna un valor por defecto o maneja el error según tu lógica
        }
    }
    public function generarCorrelativo($idTipoSalida)
    {
        // Obtener la última secuencia
        $ultimaSecuencia = $this->obtenerUltimaSecuenciaPorTipoSalida($idTipoSalida);

        // Incrementar la secuencia para el próximo correlativo
        $nuevaSecuencia = $ultimaSecuencia + 1;

        // Actualizar la secuencia en la base de datos
        $this->actualizarSecuencia($idTipoSalida, $nuevaSecuencia);

        // Obtener la letra del tipo de salida
        $letraTipoSalida = $this->obtenerLetraTipoSalida($idTipoSalida);

        // Generar el nuevo correlativo
        $correlativo = $letraTipoSalida . str_pad($nuevaSecuencia, 7, '0', STR_PAD_LEFT);

        return $correlativo;
    }

    public function actualizarSecuencia($idTipoSalida, $nuevaSecuencia)
    {
        $sql = "UPDATE tipo_salida SET ultimaSecuencia = '$nuevaSecuencia' WHERE idTipoSalida = '$idTipoSalida'";
        ejecutarConsulta($sql);
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
        CONCAT(empleado.nombre,' ',empleado.apellidoPaterno,' ',empleado.apellidoMaterno) AS empleado,
        tipo_salida.nombre as tipoSalida,
        requerimiento.correlativo,
        requerimiento.fecha,
        requerimiento.estado
        
        FROM requerimiento
        INNER JOIN ordentrabajo on ordentrabajo.idOT=requerimiento.idOT
        INNER JOIN usuario on usuario.idUsuario=requerimiento.idUsuario
        INNER JOIN tipo_salida on tipo_salida.idTiposalida=requerimiento.idTipoSalida
        INNER JOIN empleado ON empleado.idEmpleado=usuario.idEmpleado
         ORDER BY requerimiento.idRequerimiento DESC";
        return ejecutarConsulta($sql);
    }

    //listar registros
    public function listarporautorizar()
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
    INNER JOIN ordentrabajo on ordentrabajo.idOT = requerimiento.idOT
    INNER JOIN usuario on usuario.idUsuario = requerimiento.idUsuario
    INNER JOIN tipo_salida on tipo_salida.idTiposalida = requerimiento.idTipoSalida
    WHERE requerimiento.estado = 'Pendiente de Autorización'
    ORDER BY requerimiento.idRequerimiento DESC;";
        return ejecutarConsulta($sql);
    }
}
