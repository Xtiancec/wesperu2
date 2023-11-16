<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class OT{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($idEmpresa, $idAlmacen, $numero, $descripcion, $fechaInicio, $fechaFin, $estado) {
    // Verificar que los campos no estén vacíos
    if (empty($idEmpresa) || empty($idAlmacen) || empty($numero) || empty($descripcion) || empty($fechaInicio) || empty($fechaFin) || empty($estado)) {
        return "Todos los campos son obligatorios.";
    }

    // Si todos los campos están llenos, procede a la inserción en la base de datos
    $sql = "INSERT INTO ordentrabajo (idEmpresa, idAlmacen, numero, descripcion, fechaInicio, fechaFin, estado)
            VALUES ('$idEmpresa', '$idAlmacen', '$numero', '$descripcion', '$fechaInicio', '$fechaFin', '$estado')";
    
    return ejecutarConsulta($sql);
}

public function editar($idOT,$idEmpresa,$idAlmacen,$numero,$descripcion,$fechaInicio,$fechaFin,$estado){
	$sql="UPDATE ordentrabajo SET 
    idEmpresa='$idEmpresa',
    idAlmacen='$idAlmacen' ,
    numero='$numero',
    descripcion='$descripcion',
    fechaInicio='$fechaInicio',
    fechaFin='$fechaFin',
    estado='$estado'
	WHERE idOT='$idOT'";

	return ejecutarConsulta($sql);
}


//metodo para mostrar registros
public function mostrar($idOT){
	$sql="SELECT * FROM ordentrabajo WHERE idOT='$idOT'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT 
    ordentrabajo.idOT,
    ordentrabajo.idEmpresa,
    ordentrabajo.idAlmacen,
    empresa.nombre as empresa,
    almacenes.nombre as almacen,
    ordentrabajo.numero,
    ordentrabajo.descripcion,
    ordentrabajo.fechaInicio,
    ordentrabajo.fechaFin,
    ordentrabajo.estado
    FROM
    ordentrabajo
    inner join empresa on  empresa.idEmpresa=ordentrabajo.idEmpresa
    INNER join almacenes on almacenes.idAlmacen=ordentrabajo.idAlmacen";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
    $sql="SELECT 
    ordentrabajo.idOT,
    ordentrabajo.idEmpresa,
    ordentrabajo.idAlmacen,
    empresa.nombre as empresa,
    almacenes.nombre as almacen,
    ordentrabajo.numero,
    ordentrabajo.descripcion,
    ordentrabajo.fechaInicio,
    ordentrabajo.fechaFin
    FROM
    ordentrabajo
    inner join empresa on  empresa.idEmpresa=ordentrabajo.idEmpresa
    INNER join almacenes on almacenes.idAlmacen=ordentrabajo.idAlmacen
    WHERE 
    ordentrabajo.estado='EN EJECUCION'";

	return ejecutarConsulta($sql);
}

//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)

}
 ?>
