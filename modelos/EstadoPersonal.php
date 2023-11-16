<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class EstadoPersonal{
	//implementamos nuestro constructor
public function __construct(){
}

//metodo insertar regiustro
public function insertar($idEmpleado,$estado,$fechaInicio,$fechaFin){
	$sql="INSERT INTO estadopersonal (idEmpleado,estado,fechaInicio,fechaFin)
	 VALUES ($idEmpleado,$estado,$fechaInicio,$fechaFin)";
	return ejecutarConsulta($sql);
}

public function editar($idEstado,$idEmpleado,$estado,$fechaInicio,$fechaFin){
	$sql="UPDATE estadopersonal SET idEmpleado='$idEmpleado', estado='$estado' ,fechaInicio='$fechaInicio',fechaFin='$fechaFin'
	WHERE idEstado='$idEstado'";
	return ejecutarConsulta($sql);
}


//metodo para mostrar registros
public function mostrar($idEstado){
	$sql="SELECT * FROM estadopersonal WHERE idEstado='$idEstado'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT 
    estadopersonal.idEstado,
    estadopersonal.idEmpleado,
    estadopersonal.estado,
    estadopersonal.fechaInicio,
    estadopersonal.fechaFin
    from estadopersonal
    INNER JOIN empleado on  cargo.idArea=area.idArea";
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
