<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Cargo{
	//implementamos nuestro constructor
public function __construct(){
}

//metodo insertar regiustro
public function insertar($idArea,$nombre){
	$sql="INSERT INTO cargo (idArea,nombre,estado)
	 VALUES ('$idArea','$nombre','1')";
	return ejecutarConsulta($sql);
}

public function editar($idCargo,$idArea,$nombre){
	$sql="UPDATE cargo SET idArea='$idArea', nombre='$nombre' 
	WHERE idCargo='$idCargo'";
	return ejecutarConsulta($sql);
}
public function desactivar($idCargo){
	$sql="UPDATE cargo SET estado='0' WHERE idCargo='$idCargo'";
	return ejecutarConsulta($sql);
}
public function activar($idCargo){
	$sql="UPDATE cargo SET estado='1' WHERE idCargo='$idCargo'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idCargo){
	$sql="SELECT * FROM cargo WHERE idCargo='$idCargo'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT 
	cargo.idCargo, 
	cargo.idArea, 
	area.nombre as area, 
	cargo.nombre, 
	cargo.estado, 
	cargo.created_at, 
	cargo.updated_at 
	from cargo 
	INNER JOIN area on cargo.idArea=area.idArea";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
    $sql="SELECT 
    cargo.idCargo,
    cargo.idArea,
    area.nombre as area,
    cargo.nombre
    from cargo
    INNER JOIN area on  cargo.idArea=area.idArea
    WHERE cargo.estado='1'";

	return ejecutarConsulta($sql);
}

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)

}
 ?>
