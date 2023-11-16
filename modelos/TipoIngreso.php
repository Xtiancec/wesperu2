<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";


class TipoIngreso{


	//implementamos nuestro constructor


//metodo insertar regiustro


public function insertar($nombre){
	$sql="INSERT INTO tipo_ingreso (nombre,estado) VALUES ('$nombre','1')";
	return ejecutarConsulta($sql);

	}
    
public function editar($idTipoingreso,$nombre){
	$sql="UPDATE tipo_ingreso SET nombre='$nombre' 
	WHERE idTipoingreso='$idTipoingreso'";
	return ejecutarConsulta($sql);
}
public function desactivar($idTipoingreso){
	$sql="UPDATE tipo_ingreso SET estado='0' WHERE idTipoingreso='$idTipoingreso'";
	return ejecutarConsulta($sql);
}
public function activar($idTipoingreso){
	$sql="UPDATE tipo_ingreso SET estado='1' WHERE idTipoingreso='$idTipoingreso'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idTipoingreso){
	$sql="SELECT * FROM tipo_ingreso WHERE idTipoingreso='$idTipoingreso'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM tipo_ingreso";
	return ejecutarConsulta($sql);
}
//listar y mostrar en select
public function select(){
	$sql="SELECT idTipoingreso, nombre FROM tipo_ingreso WHERE estado=1";
	return ejecutarConsulta($sql);
}
}

 ?>
