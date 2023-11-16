<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";


class UM{


public function insertar($nombre,$descripcion){
	$sql="INSERT INTO unidad_medida_existencia (nombre,descripcion,estado) VALUES ('$nombre','$descripcion','1')";
	return ejecutarConsulta($sql);

	}
    
public function editar($idUM,$nombre,$descripcion){
	$sql="UPDATE unidad_medida_existencia SET nombre='$nombre',descripcion='$descripcion' 
	WHERE idUM='$idUM'";
	return ejecutarConsulta($sql);
}
public function desactivar($idUM){
	$sql="UPDATE unidad_medida_existencia SET estado='0' WHERE idUM='$idUM'";
	return ejecutarConsulta($sql);
}
public function activar($idUM){
	$sql="UPDATE unidad_medida_existencia SET estado='1' WHERE idUM='$idUM'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idUM){
	$sql="SELECT * FROM unidad_medida_existencia WHERE idUM='$idUM'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM unidad_medida_existencia";
	return ejecutarConsulta($sql);
}
//listar y mostrar en select
public function select(){
	$sql="SELECT * FROM unidad_medida_existencia WHERE estado=1";
	return ejecutarConsulta($sql);
}
}

 ?>
