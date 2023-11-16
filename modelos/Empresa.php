<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Empresa{
	//implementamos nuestro constructor
public function __construct(){
}

//metodo insertar regiustro
public function insertar($idBanco,$tipoEmpresa,$nombre,$RUC,$numeroDocumento,$direccion,$estados,$condicion,$departamento,$provincia,$distrito,$telefono,$numeroCuenta,$informacionGeneral){
	$sql="INSERT INTO empresa (idBanco,tipoEmpresa,nombre,RUC,numeroDocumento,direccion,estados,condicion,departamento,provincia,distrito,telefono,numeroCuenta,informacionGeneral,estado)
	 VALUES ('$idBanco','$tipoEmpresa','$nombre','$RUC','$numeroDocumento','$direccion','$estados','$condicion','$departamento','$provincia','$distrito','$telefono','$numeroCuenta','$informacionGeneral','1')";
	return ejecutarConsulta($sql);
}

public function editar($idEmpresa,$idBanco,$tipoEmpresa,$nombre,$RUC,$numeroDocumento,$direccion,$estados,$condicion,$departamento,$provincia,$distrito,$telefono,$numeroCuenta,$informacionGeneral){
	$sql="UPDATE empresa SET 
     idEmpresa='$idEmpresa',
     idBanco='$idBanco',
     tipoEmpresa='$tipoEmpresa',
     nombre='$nombre',
     RUC='$RUC',
     numeroDocumento='$numeroDocumento'
     direccion='$direccion',
     estados='$estados',
     condicion='$condicion',
     departamento='$departamento',
     provincia='$provincia',
     distrito='$distrito',
     telefono='$telefono',
     numeroCuenta='$numeroCuenta',
     informacionGeneral='$informacionGeneral'

	WHERE idEmpresa='$idEmpresa'";
	return ejecutarConsulta($sql);
}


//metodo para mostrar registros
public function mostrar($idEmpresa){
	$sql="SELECT * FROM empresa WHERE idEmpresa='$idEmpresa'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT
    empresa.idEmpresa,
    empresa.idBanco,
    empresa.tipoEmpresa,
    empresa.nombre,
    banco.nombre as banco,
    empresa.numeroDocumento,
    empresa.telefono,
    empresa.numeroCuenta,
    empresa.informacionGeneral,
    empresa.estado
    FROM
    empresa
    INNER join banco on banco.idBanco=empresa.idBanco";
	return ejecutarConsulta($sql);
}

//listar registros activos
public function listarActivos(){
    $sql="SELECT
    empresa.idEmpresa,
    empresa.idBanco,
    empresa.nombre,
    empresa.tipoEmpresa,
    banco.nombre as banco,
    empresa.RUC,
    empresa.telefono,
    empresa.numeroCuenta,
    empresa.informacionGeneral
    
    FROM
    empresa
    INNER join banco on banco.idBanco=empresa.idBanco

    WHERE empresa.estado='1'";

	return ejecutarConsulta($sql);
}

public function selectProveedores(){
    $sql="SELECT
    idEmpresa,
    empresa.nombre
    FROM
    empresa
   
    WHERE tipoEmpresa='Proveedor'";
	return ejecutarConsulta($sql);

   
}



public function listarProveedores(){
    $sql="SELECT
    empresa.idEmpresa,
    empresa.idBanco,
    empresa.tipoEmpresa,
    empresa.nombre,
    banco.nombre as banco,
    empresa.numeroDocumento,
    empresa.telefono,
    empresa.numeroCuenta,
    empresa.informacionGeneral,
    empresa.estado
    FROM
    empresa
    INNER join banco on banco.idBanco=empresa.idBanco
    WHERE tipoEmpresa='Proveedor'";
	return ejecutarConsulta($sql);

   
}

public function listarClientes(){
    $sql="SELECT
    empresa.idEmpresa,
    empresa.idBanco,
    empresa.tipoEmpresa,
    empresa.nombre,
    banco.nombre as banco,
    empresa.numeroDocumento,
    empresa.telefono,
    empresa.numeroCuenta,
    empresa.informacionGeneral,
    empresa.estado
    FROM
    empresa
    INNER join banco on banco.idBanco=empresa.idBanco
    WHERE tipoEmpresa='Cliente'";
	return ejecutarConsulta($sql);


}


//implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)
public function desactivar($idEmpresa){
	$sql="UPDATE empresa SET estado='0' WHERE idEmpresa='$idEmpresa'";
	return ejecutarConsulta($sql);
}
public function activar($idEmpresa){
	$sql="UPDATE empresa SET estado='1' WHERE idEmpresa='$idEmpresa'";
	return ejecutarConsulta($sql);
}


}
 ?>
