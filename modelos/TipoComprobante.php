<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";


class TipoComprobante{


	//implementamos nuestro constructor


//metodo insertar regiustro


public function insertar($nombre){
	$sql="INSERT INTO tipo_comprobante (nombre,estado) VALUES ('$nombre','1')";
	return ejecutarConsulta($sql);

	}
    
public function editar($idTipocomprobante,$nombre){
	$sql="UPDATE tipo_comprobante SET nombre='$nombre' 
	WHERE idTipocomprobante='$idTipocomprobante'";
	return ejecutarConsulta($sql);
}
public function desactivar($idTipocomprobante){
	$sql="UPDATE tipo_comprobante SET estado='0' WHERE idTipocomprobante='$idTipocomprobante'";
	return ejecutarConsulta($sql);
}
public function activar($idTipocomprobante){
	$sql="UPDATE tipo_comprobante SET estado='1' WHERE idTipocomprobante='$idTipocomprobante'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idTipocomprobante){
	$sql="SELECT * FROM tipo_comprobante WHERE idTipocomprobante='$idTipocomprobante'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM tipo_comprobante";
	return ejecutarConsulta($sql);
}
//listar y mostrar en select
public function select(){
	$sql="SELECT * FROM tipo_comprobante WHERE estado=1";
	return ejecutarConsulta($sql);
}
}

 ?>
