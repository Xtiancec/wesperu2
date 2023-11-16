<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";


class Banco{


	//implementamos nuestro constructor


//metodo insertar regiustro


public function insertar($nombre,$tipoBanco){
	$sql="INSERT INTO banco (nombre,tipoBanco,estado) VALUES ('$nombre','$tipoBanco','1')";
	return ejecutarConsulta($sql);

	}
    
public function editar($idBanco,$nombre,$tipoBanco){
	$sql="UPDATE banco SET nombre='$nombre',tipoBanco='$tipoBanco' 
	WHERE idBanco='$idBanco'";
	return ejecutarConsulta($sql);
}
public function desactivar($idBanco){
	$sql="UPDATE banco SET estado='0' WHERE idBanco='$idBanco'";
	return ejecutarConsulta($sql);
}
public function activar($idBanco){
	$sql="UPDATE banco SET estado='1' WHERE idBanco='$idBanco'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idBanco){
	$sql="SELECT * FROM banco WHERE idBanco='$idBanco'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM banco";
	return ejecutarConsulta($sql);
}
//listar y mostrar en select
public function select(){
	$sql="SELECT * FROM banco WHERE estado=1";
	return ejecutarConsulta($sql);
}
}

 ?>
