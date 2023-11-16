<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";


class TipoSalida{


	//implementamos nuestro constructor


//metodo insertar regiustro


public function insertar($nombre){
	$sql="INSERT INTO tipo_salida (nombre,estado) VALUES ('$nombre','1')";
	return ejecutarConsulta($sql);

	}
    
public function editar($idTiposalida,$nombre){
	$sql="UPDATE tipo_salida SET nombre='$nombre' 
	WHERE idTiposalida='$idTiposalida'";
	return ejecutarConsulta($sql);
}
public function desactivar($idTiposalida){
	$sql="UPDATE tipo_salida SET estado='0' WHERE idTiposalida='$idTiposalida'";
	return ejecutarConsulta($sql);
}
public function activar($idTiposalida){
	$sql="UPDATE tipo_salida SET estado='1' WHERE idTiposalida='$idTiposalida'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idTiposalida){
	$sql="SELECT * FROM tipo_salida WHERE idTiposalida='$idTiposalida'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM tipo_salida";
	return ejecutarConsulta($sql);
}
//listar y mostrar en select
public function select(){
	$sql="SELECT * FROM tipo_salida WHERE estado=1";
	return ejecutarConsulta($sql);
}
}

 ?>
