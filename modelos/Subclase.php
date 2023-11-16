<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class SubClase{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($idClase,$nombre){
	$sql="INSERT INTO subclase (idClase,nombre,estado)
	 VALUES ('$idClase','$nombre','1')";
	return ejecutarConsulta($sql);
}

public function editar($idSubclase,$idClase,$nombre){
	$sql="UPDATE subclase SET idClase='$idClase', nombre='$nombre' 
	WHERE idSubclase='$idSubclase'";
	return ejecutarConsulta($sql);
}
public function desactivar($idSubclase){
	$sql="UPDATE subclase SET estado='0' WHERE idSubclase='$idSubclase'";
	return ejecutarConsulta($sql);
}
public function activar($idSubclase){
	$sql="UPDATE subclase SET estado='1' WHERE idSubclase='$idSubclase'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idSubclase){
	$sql="SELECT * FROM subclase WHERE idSubclase='$idSubclase'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT 
    subclase.idSubclase,
    subclase.idClase,
    clase.nombre as clase,
    subclase.nombre,
    subclase.estado
    from subclase
    INNER JOIN clase on  clase.idClase=subclase.idClase";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
    $sql="SELECT 
    subclase.idSubclase,
    subclase.idClase,
    clase.nombre as clase,
    subclase.nombre 
    from subclase
    INNER JOIN clase on  clase.idClase=subclase.idClase
    WHERE subclase.estado='1'";

	return ejecutarConsulta($sql);
}

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)

}
 ?>
