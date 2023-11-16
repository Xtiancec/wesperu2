<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Comprobante{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($idTipocomprobante,$idEmpresa,$idTipoingreso,$idAlmacen,$numero,$fecha,$precioTotal,$idExistencia,$cantidad,$precio){
	$sql="INSERT INTO comprobante (idTipocomprobante,idEmpresa,idTipoingreso,idAlmacen,numero,fecha,precioTotal,estado) VALUES 
    ('$idTipocomprobante','$idEmpresa','$idTipoingreso','$idAlmacen','$numero','$fecha','$precioTotal','Aceptado')";
	
    
    //return ejecutarConsulta($sql);
    $idingresonew=ejecutarConsulta_retornarID($sql);
    $num_elementos=0;
    $sw=true;

    while($num_elementos < count($idExistencia)){
        $sql_detalle="INSERT INTO ingreso(idExistencia,idComprobante,cantidad,precio,stockIngresoPrecio)
        VALUES('$idExistencia[$num_elementos]','$idingresonew','$cantidad[$num_elementos]','$precio[$num_elementos]','$cantidad[$num_elementos]');" ;

        

        
        ejecutarConsulta($sql_detalle) or $sw=false;
        
        $num_elementos=$num_elementos+1;
    
    
    }
    return $sw;

}


public function editar($idComprobante, $idTipocomprobante, $idEmpresa, $idTipoingreso, $idAlmacen, $numero, $fecha, $precioTotal, $idExistencia, $cantidad, $precio) {
    $sql = "UPDATE comprobante SET
            idTipocomprobante = '$idTipocomprobante',
            idEmpresa = '$idEmpresa',
            idTipoingreso = '$idTipoingreso',
            idAlmacen = '$idAlmacen',
            numero = '$numero',
            fecha = '$fecha',
            precioTotal = '$precioTotal'
            WHERE idComprobante = '$idComprobante'";

    ejecutarConsulta($sql);

    $num_elementos = 0;
    $sw = true;

    while ($num_elementos < count($idExistencia)) {
        $idExistenciaDetalle = $idExistencia[$num_elementos];  
        $cantidadDetalle = $cantidad[$num_elementos];
        $precioDetalle = $precio[$num_elementos];

        // Verificar si el detalle ya existe
        $sql_existente = "SELECT * FROM ingreso WHERE idComprobante = '$idComprobante' AND idExistencia = '$idExistenciaDetalle'";
        $result_existente = ejecutarConsultaSimpleFila($sql_existente);

        if ($result_existente) {
            // Si el detalle existe, actualiza la cantidad y el precio
            $sql_update_detalle = "UPDATE ingreso SET cantidad = '$cantidadDetalle', precio = '$precioDetalle', stockIngresoPrecio = '$cantidadDetalle'
                                    WHERE idComprobante = '$idComprobante' AND idExistencia = '$idExistenciaDetalle'";
            ejecutarConsulta($sql_update_detalle) or $sw = false;
        } else {
            // Si el detalle no existe, inserta un nuevo registro
            $sql_insert_detalle = "INSERT INTO ingreso(idExistencia, idComprobante, cantidad, precio, stockIngresoPrecio)
                                    VALUES('$idExistenciaDetalle', '$idComprobante', '$cantidadDetalle', '$precioDetalle', '$cantidadDetalle');";
            ejecutarConsulta($sql_insert_detalle) or $sw = false;
        }

        $num_elementos = $num_elementos + 1;
    }

    return $sw;
}


public function anular($idComprobante){
	$sql="UPDATE comprobante SET estado='Anulado' WHERE idComprobante='$idComprobante'";
	return ejecutarConsulta($sql);
}




//metodo para mostrar registros
public function mostrar($idComprobante){
	$sql="SELECT 
    comprobante.idComprobante,
    comprobante.idTipocomprobante,
    comprobante.numero,
    comprobante.fecha as fecha,
    tipo_comprobante.nombre as tipoComprobante,
    almacenes.nombre as almacen,
    tipo_ingreso.nombre as tipoIngreso,
    empresa.nombre as empresa,
    comprobante.precioTotal,
    comprobante.estado
    
    FROM comprobante 
    
    INNER JOIN empresa on empresa.idEmpresa=comprobante.idEmpresa
    INNER JOIN tipo_comprobante on tipo_comprobante.idTipocomprobante=comprobante.idTipocomprobante
    INNER JOIN tipo_ingreso on tipo_ingreso.idTipoingreso=comprobante.idTipoingreso
    INNER JOIN almacenes on almacenes.idAlmacen=comprobante.idAlmacen
      
    WHERE idComprobante='$idComprobante'";
	return ejecutarConsultaSimpleFila($sql);
}



public function listarDetalle($idComprobante){
	$sql="SELECT 
    ingreso.idComprobante,
    ingreso.idIngreso,
    ingreso.idExistencia,
    comprobante.numero as comprobante,
    existencia.nombre as existencia,
    unidad_medida_existencia.nombre as um,
    ingreso.cantidad,
    ingreso.precio,
    ingreso.cantidad*ingreso.precio as subTotal
    
    FROM
    ingreso
    
    INNER JOIN existencia on existencia.idExistencia=ingreso.idExistencia
    INNER JOIN comprobante on comprobante.idComprobante=ingreso.idComprobante
    INNER JOIN unidad_medida_existencia on existencia.idUM=unidad_medida_existencia.idUM
    WHERE ingreso.idComprobante='$idComprobante'";

	return ejecutarConsulta($sql);
}


//listar registros
public function listar(){
	$sql="SELECT 
    comprobante.idComprobante,
    comprobante.idTipocomprobante,
    comprobante.numero,
    comprobante.fecha as fecha,
    tipo_comprobante.nombre as tipoComprobante,
    almacenes.nombre as almacen,
    tipo_ingreso.nombre as tipoIngreso,
    empresa.nombre as empresa,
    comprobante.precioTotal,
    comprobante.estado
    
    FROM comprobante 
    
    INNER JOIN empresa on empresa.idEmpresa=comprobante.idEmpresa
    INNER JOIN tipo_comprobante on tipo_comprobante.idTipocomprobante=comprobante.idTipocomprobante
    INNER JOIN tipo_ingreso on tipo_ingreso.idTipoingreso=comprobante.idTipoingreso
    INNER JOIN almacenes on almacenes.idAlmacen=comprobante.idAlmacen
    ORDER BY comprobante.idComprobante DESC";
	return ejecutarConsulta($sql);
}

}

 ?>
