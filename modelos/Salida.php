<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Salida{
	//implementamos nuestro constructor
public function __construct(){
}

public function actualizarCantidadIngreso($idIngreso, $nuevaCantidad) {
    $sql = "UPDATE ingreso SET stockIngresoPrecio = '$nuevaCantidad' WHERE idIngreso = '$idIngreso'";
    return ejecutarConsulta($sql);
}

function calcularCostoReal($idExistencia, $cantidadDeseada) {
    $sql = "SELECT idIngreso, precio, stockIngresoPrecio FROM ingreso WHERE idExistencia = '$idExistencia' AND stockIngresoPrecio > 0 ORDER BY created_at";
    $result = ejecutarConsulta($sql); // Ejecutamos la consulta

    $costoTotal = 0;
    $cantidadDisponible = 0;

    $updates = array(); // Almacenar actualizaciones pendientes

    foreach ($result as $ingreso) {
        $idIngreso = $ingreso["idIngreso"];
        $precioUnitario = $ingreso["precio"];
        $cantidadIngreso = $ingreso["stockIngresoPrecio"];

        if ($cantidadDeseada > $cantidadIngreso) {
            // Si la cantidad deseada es mayor que la cantidad del ingreso actual, lo usamos por completo
            $costoTotal += $precioUnitario * $cantidadIngreso;
            $cantidadDeseada -= $cantidadIngreso;
            $cantidadDisponible += $cantidadIngreso;
            // Almacena la actualización pendiente
            $updates[$idIngreso] = 0;
        } else {
            // Si la cantidad deseada es menor o igual a la cantidad del ingreso actual, usamos solo la cantidad deseada
            $costoTotal += $precioUnitario * $cantidadDeseada;
            $cantidadDisponible += $cantidadDeseada;
            // Almacena la actualización pendiente
            $updates[$idIngreso] = $cantidadIngreso - $cantidadDeseada;
            break;
        }
    }

    // Calcula el costo unitario
    $costoUnitario = ($cantidadDisponible > 0) ? $costoTotal / $cantidadDisponible : 0;

    // Devuelve el costo unitario y las actualizaciones pendientes
    return array("costoUnitario" => $costoUnitario, "updates" => $updates);
}





public function calcularPrecioUltimo($idExistencia){
    $sql="SELECT precioActual from existencia WHERE idExistencia='$idExistencia'";
    return ejecutarConsultaSimpleFila($sql);
 
}


//metodo insertar SALIDA
public function insertar($idExistencia,$idTiposalida,$idOT,$idEmpleado,$fecha,$cantidad,$costoUnitario,$subTotal){
	$sql="INSERT INTO salida (idExistencia, idTiposalida, idOT, idEmpleado, fecha, cantidad, costoUnitario, subTotal)
    VALUES ('$idExistencia', '$idTiposalida', '$idOT', '$idEmpleado', '$fecha', '$cantidad', '$costoUnitario', '$subTotal');
    
";
	return ejecutarConsulta($sql);
}



public function editar($idSalida,$idExistencia,$idTiposalida,$idOT,$idEmpleado,$fecha,$cantidad,$costoUnitario,$subTotal){
	$sql="UPDATE salida SET 
     idSalida='$idSalida',
     idExistencia='$idExistencia',
     idTiposalida='$idTiposalida',
     idOT='$idOT',
     idEmpleado='$idEmpleado',
     fecha='$fecha',
     cantidad='$cantidad',
     costoUnitario='$costoUnitario',
     subTotal='$subTotal'

	WHERE idSalida='$idSalida'";
	return ejecutarConsulta($sql);
}


//metodo para mostrar registros
public function mostrar($idSalida){
	$sql="SELECT * FROM salida WHERE idSalida='$idSalida'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros 
public function listar(){
	$sql="SELECT
    salida.idSalida,
    salida.idExistencia,
    salida.idTiposalida,
    salida.idOT,
    salida.idEmpleado,
    almacenes.nombre as almacen,
    CONCAT(empleado.apellidoPaterno,' ',empleado.apellidoMaterno,' ',empleado.nombre) AS empleado,
    ordentrabajo.numero as ot,
    tipo_salida.nombre as tipoSalida,
    existencia.nombre as existencia,
    salida.fecha,
    salida.cantidad,
    salida.costoUnitario,
    salida.subTotal
    from 
    salida

    inner join ordentrabajo on ordentrabajo.idOT=salida.idOT
    inner join empleado on empleado.idEmpleado=salida.idEmpleado
    inner join tipo_salida on tipo_salida.idTiposalida=salida.idTiposalida
    inner join existencia on existencia.idExistencia=salida.idExistencia
    inner join almacenes on almacenes.idAlmacen=ordentrabajo.idAlmacen
    GROUP BY idSalida
    
    
 
    ";
	return ejecutarConsulta($sql);
}



}
 ?>
