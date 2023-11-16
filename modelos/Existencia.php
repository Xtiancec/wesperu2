<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Existencia{
	//implementamos nuestro constructor
public function __construct(){
}

//metodo insertar registro
public function insertar($idSubclase,$idUM,$nombre,$stockInicial,$precioActual,$autorizacion){
	$sql="INSERT INTO existencia (idSubclase,idUM,nombre,stockActual,stockInicial,precioActual,precioPromedio,autorizacion,estado)
	 VALUES ('$idSubclase','$idUM','$nombre','$stockInicial','$stockInicial','$precioActual','$precioActual','$autorizacion','1')";
	return ejecutarConsulta($sql);
}

public function editar($idExistencia,$idSubclase,$idUM,$nombre,$autorizacion){
	$sql="UPDATE existencia SET idSubclase='$idSubclase', idUM='$idUM',nombre='$nombre', autorizacion='$autorizacion'
	WHERE idExistencia='$idExistencia'";
	return ejecutarConsulta($sql);
}
public function desactivar($idExistencia){
	$sql="UPDATE existencia SET estado='0' WHERE idExistencia='$idExistencia'";
	return ejecutarConsulta($sql);
}
public function activar($idExistencia){
	$sql="UPDATE existencia SET estado='1' WHERE idExistencia='$idExistencia'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idExistencia){
	$sql="SELECT * FROM existencia WHERE idExistencia='$idExistencia'";
	return ejecutarConsultaSimpleFila($sql);
}
//SELECT idExistencia, precio FROM ingreso WHERE (idExistencia, update_at) IN ( SELECT idExistencia, MAX(update_at) FROM ingreso GROUP BY idExistencia );
//listar registros 
public function listado2(){
	$sql="SELECT existencia.idExistencia, 
    existencia.idSubclase, 
    existencia.idUM, 
    clase.nombre as clase, 
    subclase.nombre as subclase,
     existencia.nombre,
      unidad_medida_existencia.nombre as um,
      existencia.autorizacion,
       SUM(ingreso.cantidad) as stock, 
       ROUND(AVG(ingreso.precio),2) as precioActual, 
       existencia.estado FROM existencia
        INNER JOIN subclase ON existencia.idSubclase = subclase.idSubclase 
        INNER JOIN unidad_medida_existencia ON existencia.idUM = unidad_medida_existencia.idUM 
        INNER JOIN clase ON clase.idClase = subclase.idClase 
        INNER JOIN ingreso ON ingreso.idExistencia = existencia.idExistencia 
        GROUP BY existencia.idExistencia;
";
	return ejecutarConsulta($sql);
}

public function listar(){
	$sql="SELECT existencia.idExistencia, 
    existencia.idSubclase, 
    existencia.idUM, 
    clase.nombre as clase, 
    subclase.nombre as subclase,
    existencia.nombre,
    unidad_medida_existencia.nombre as um,
    existencia.stockActual, 
    existencia.precioActual,
    existencia.autorizacion,
       existencia.estado FROM existencia
        INNER JOIN subclase ON existencia.idSubclase = subclase.idSubclase 
        INNER JOIN unidad_medida_existencia ON existencia.idUM = unidad_medida_existencia.idUM 
        INNER JOIN clase ON clase.idClase = subclase.idClase 
        GROUP BY existencia.idExistencia;
";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
    $sql="SELECT 
    existencia.idExistencia, 
    existencia.idSubclase, 
    existencia.idUM, 
    clase.nombre as clase, 
    subclase.nombre as subclase, 
    existencia.nombre, 
    existencia.stockActual, 
    existencia.precioActual, 
    unidad_medida_existencia.nombre as um,
    existencia.autorizacion
    FROM existencia 
     INNER JOIN subclase ON existencia.idSubclase = subclase.idSubclase 
     INNER JOIN unidad_medida_existencia ON existencia.idUM = unidad_medida_existencia.idUM 
     INNER JOIN clase ON clase.idClase = subclase.idClase      
  
     
     WHERE existencia.estado = 1 GROUP BY existencia.idExistencia;";

	return ejecutarConsulta($sql);
}




//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)

}
 ?>
