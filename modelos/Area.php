<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";


class Area{


	//implementamos nuestro constructor


//metodo insertar regiustro


public function insertar($nombre){
	$sql="INSERT INTO area (nombre,estado) VALUES ('$nombre','1')";
	return ejecutarConsulta($sql);

	}
    
public function editar($idArea,$nombre){
	$sql="UPDATE area SET nombre='$nombre' 
	WHERE idArea='$idArea'";
	return ejecutarConsulta($sql);
}
public function desactivar($idArea){
	$sql="UPDATE area SET estado='0' WHERE idArea='$idArea'";
	return ejecutarConsulta($sql);
}
public function activar($idArea){
	$sql="UPDATE area SET estado='1' WHERE idArea='$idArea'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idArea){
	$sql="SELECT * FROM area WHERE idArea='$idArea'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM area";
	return ejecutarConsulta($sql);
}
//listar y mostrar en select
public function select(){
	$sql="SELECT * FROM area WHERE estado=1";
	return ejecutarConsulta($sql);
}
}

 ?>
