<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";


class Clase{


	//implementamos nuestro constructor


//metodo insertar regiustro


public function insertar($nombre){
	$sql="INSERT INTO clase (nombre,estado) VALUES ('$nombre','1')";
	return ejecutarConsulta($sql);

	}
    
public function editar($idClase,$nombre){
	$sql="UPDATE clase SET nombre='$nombre' 
	WHERE idClase='$idClase'";
	
	return ejecutarConsulta($sql);
}
public function desactivar($idClase){
	$sql="UPDATE clase SET estado='0' WHERE idClase='$idClase'";
	return ejecutarConsulta($sql);
}
public function activar($idClase){
	$sql="UPDATE clase SET estado='1' WHERE idClase='$idClase'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idClase){
	$sql="SELECT * FROM clase WHERE idClase='$idClase'";
	
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM clase";
	return ejecutarConsulta($sql);
}
//listar y mostrar en select
public function select(){
	$sql="SELECT * FROM clase WHERE estado=1";
	return ejecutarConsulta($sql);
}
}

 ?>
