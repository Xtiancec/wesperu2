<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Consultas{


	//implementamos nuestro constructor
public function __construct(){

}



//listar registros
public function comprasfecha($fecha_inicio,$fecha_fin){
	$sql="SELECT DATE(i.fecha_hora) as fecha, u.nombre as usuario, p.nombre as proveedor, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante, i.total_compra,i.impuesto,i.estado FROM ingreso i
     INNER JOIN persona p ON i.idproveedor=p.idpersona 
     INNER JOIN usuario u ON i.idusuario=u.idusuario 
     
     WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";

	return ejecutarConsulta($sql);
}


public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente){
	$sql="SELECT DATE(v.fecha_hora) as fecha, u.nombre as usuario, p.nombre as cliente, v.tipo_comprobante,v.serie_comprobante, v.num_comprobante , v.total_venta, v.impuesto, v.estado FROM venta v 
    INNER JOIN persona p ON v.idcliente=p.idpersona 
    INNER JOIN usuario u ON v.idusuario=u.idusuario 
    
    WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.idcliente='$idcliente'";
	return ejecutarConsulta($sql);
}

public function totalcomprahoy(){
	$sql="SELECT SUM(precioTotal) AS total_de_ingresos_hoy FROM comprobante WHERE DATE(fecha) = CURDATE() AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}

public function totalsalidahoy(){
	$sql="SELECT SUM(subTotal) AS total_de_salidas_hoy FROM salida WHERE DATE(fecha) = CURDATE()";
	return ejecutarConsulta($sql);
}

public function totalventahoy(){
	$sql="SELECT IFNULL(SUM(total_venta),0) as total_venta FROM venta WHERE DATE(fecha_hora)=curdate()";
	return ejecutarConsulta($sql);
}

public function ingresosmes(){
	$sql="SELECT SUM(precioTotal) AS ingresoMes FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = MONTH(CURDATE()) AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}

public function salidames(){
	$sql="SELECT SUM(subTotal) AS salidaMes FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = MONTH(CURDATE())";
	return ejecutarConsulta($sql);
}
/**INGRESOS POR MES DEL AÑO ACTUAL*/
public function ingresoEnero(){
	$sql="SELECT SUM(precioTotal) AS ingresoEnero FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 1 AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}
public function ingresoFebrero(){
	$sql="SELECT SUM(precioTotal) AS ingresoFebrero FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 2 AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}
public function ingresoMarzo(){
	$sql="SELECT SUM(precioTotal) AS ingresoMarzo FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 3 AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}
public function ingresoAbril(){
	$sql="SELECT SUM(precioTotal) AS ingresoAbril FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 4 AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}
public function ingresoMayo(){
	$sql="SELECT SUM(precioTotal) AS ingresoMayo FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 5 AND estado='Aceptado'";
	return ejecutarConsulta($sql);

}public function ingresoJunio(){
	$sql="SELECT SUM(precioTotal) AS ingresoJunio FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 6 AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}

public function ingresoJulio(){
	$sql="SELECT SUM(precioTotal) AS ingresoJulio FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 7 AND estado='Aceptado'";
	return ejecutarConsulta($sql);

}public function ingresoAgosto(){
	$sql="SELECT SUM(precioTotal) AS ingresoAgosto FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 8 AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}
public function ingresoSetiembre(){
	$sql="SELECT SUM(precioTotal) AS ingresoSetiembre FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 9 AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}
public function ingresoOctubre(){
	$sql="SELECT SUM(precioTotal) AS ingresoOctubre FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 10 AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}
public function ingresoNoviembre(){
	$sql="SELECT SUM(precioTotal) AS ingresoNoviembre FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 11 AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}
public function ingresoDiciembre(){
	$sql="SELECT SUM(precioTotal) AS ingresoDiciembre FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 12 AND estado='Aceptado'";
	return ejecutarConsulta($sql);
}

public function ingresoAnual(){
	$sql="SELECT SUM(precioTotal) AS ingresoAnual FROM comprobante WHERE YEAR(fecha) = YEAR(CURDATE()) AND estado='Aceptado';
	";
	return ejecutarConsulta($sql);
}

/**INGRESOS POR MES DEL AÑO ACTUAL*/
public function salidaEnero(){
	$sql="SELECT SUM(subTotal) AS salidaEnero FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 1";
	return ejecutarConsulta($sql);
}

public function salidaFebrero(){
	$sql="SELECT SUM(subTotal) AS salidaFebrero FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 2";
	return ejecutarConsulta($sql);
}

public function salidaMarzo(){
	$sql="SELECT SUM(subTotal) AS salidaMarzo FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 3";
	return ejecutarConsulta($sql);
}

public function salidaAbril(){
	$sql="SELECT SUM(subTotal) AS salidaAbril FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 4";
	return ejecutarConsulta($sql);
}

public function salidaMayo(){
	$sql="SELECT SUM(subTotal) AS salidaMayo FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 5";
	return ejecutarConsulta($sql);
}

public function salidaJunio(){
	$sql="SELECT SUM(subTotal) AS salidaJunio FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 6";
	return ejecutarConsulta($sql);
}

public function salidaJulio(){
	$sql="SELECT SUM(subTotal) AS salidaJulio FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 7";
	return ejecutarConsulta($sql);
}

public function salidaAgosto(){
	$sql="SELECT SUM(subTotal) AS salidaAgosto FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 8";
	return ejecutarConsulta($sql);
}

public function salidaSetiembre(){
	$sql="SELECT SUM(subTotal) AS salidaSetiembre FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 9";
	return ejecutarConsulta($sql);
}

public function salidaOctubre(){
	$sql="SELECT SUM(subTotal) AS salidaOctubre FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 10";
	return ejecutarConsulta($sql);
}

public function salidaNoviembre(){
	$sql="SELECT SUM(subTotal) AS salidaNoviembre FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 11";
	return ejecutarConsulta($sql);
}

public function salidaDiciembre(){
	$sql="SELECT SUM(subTotal) AS salidaDiciembre FROM salida WHERE YEAR(fecha) = YEAR(CURDATE()) AND MONTH(fecha) = 12";
	return ejecutarConsulta($sql);
}




public function ingresoSemanal(){
	$sql="SELECT SUM(precioTotal) AS ingresoSemanal FROM comprobante WHERE fecha BETWEEN DATE_ADD(CURDATE(), INTERVAL (1-DAYOFWEEK(CURDATE())) DAY)
	AND DATE_ADD(CURDATE(), INTERVAL (7-DAYOFWEEK(CURDATE())) DAY) AND estado='Aceptado';
	";
	return ejecutarConsulta($sql);
}

/**INGRESOS POR DIA DE SEMANA  ACTUAL*/
public function ingresoLunes(){
	$sql="SELECT SUM(cantidad * precio) AS ingresoLunes FROM ingreso WHERE WEEK(created_at) = WEEK(NOW()) AND DAYOFWEEK(created_at) =2;";
	return ejecutarConsulta($sql);
}

public function ingresoMartes(){
	$sql="SELECT SUM(cantidad * precio) AS ingresoMartes FROM ingreso WHERE WEEK(created_at) = WEEK(NOW()) AND DAYOFWEEK(created_at) =3;";
	return ejecutarConsulta($sql);
}
public function ingresoMiercoles(){
	$sql="SELECT SUM(cantidad * precio) AS ingresoMiercoles FROM ingreso WHERE WEEK(created_at) = WEEK(NOW()) AND DAYOFWEEK(created_at) =4;";
	return ejecutarConsulta($sql);
}
public function ingresoJueves(){
	$sql="SELECT SUM(cantidad * precio) AS ingresoJueves FROM ingreso WHERE WEEK(created_at) = WEEK(NOW()) AND DAYOFWEEK(created_at) =5;";
	return ejecutarConsulta($sql);
}
public function ingresoViernes(){
	$sql="SELECT SUM(cantidad * precio) AS ingresoViernes FROM ingreso WHERE WEEK(created_at) = WEEK(NOW()) AND DAYOFWEEK(created_at) =6;";
	return ejecutarConsulta($sql);
}
public function ingresoSabado(){
	$sql="SELECT SUM(cantidad * precio) AS ingresoSabado FROM ingreso WHERE WEEK(created_at) = WEEK(NOW()) AND DAYOFWEEK(created_at) =7;";
	return ejecutarConsulta($sql);
}
public function ingresoDomingo(){
	$sql="SELECT SUM(cantidad * precio) AS ingresoDomingo FROM ingreso WHERE WEEK(created_at) = WEEK(NOW()) AND DAYOFWEEK(created_at) =8;";
	return ejecutarConsulta($sql);
}



/**salida POR DIA DE SEMANA  ACTUAL*/
public function salidaLunes(){
	$sql="SELECT SUM(cantidad * costoUnitario) AS salidaLunes FROM salida WHERE WEEK(fecha) = WEEK(NOW()) AND DAYOFWEEK(fecha) =2;";
	return ejecutarConsulta($sql);
}

public function salidaMartes(){
	$sql="SELECT SUM(cantidad * costoUnitario) AS salidaMartes FROM salida WHERE WEEK(fecha) = WEEK(NOW()) AND DAYOFWEEK(fecha) =3;";
	return ejecutarConsulta($sql);
}
public function salidaMiercoles(){
	$sql="SELECT SUM(cantidad * costoUnitario) AS salidaMiercoles FROM salida WHERE WEEK(fecha) = WEEK(NOW()) AND DAYOFWEEK(fecha) =4;";
	return ejecutarConsulta($sql);
}
public function salidaJueves(){
	$sql="SELECT SUM(cantidad * costoUnitario) AS salidaJueves FROM salida WHERE WEEK(fecha) = WEEK(NOW()) AND DAYOFWEEK(fecha) =5;";
	return ejecutarConsulta($sql);
}
public function salidaViernes(){
	$sql="SELECT SUM(cantidad * costoUnitario) AS salidaViernes FROM salida WHERE WEEK(fecha) = WEEK(NOW()) AND DAYOFWEEK(fecha) =6;";
	return ejecutarConsulta($sql);
}
public function salidaSabado(){
	$sql="SELECT SUM(cantidad * costoUnitario) AS salidaSabado FROM salida WHERE WEEK(fecha) = WEEK(NOW()) AND DAYOFWEEK(fecha) =7;";
	return ejecutarConsulta($sql);
}
public function salidaDomingo(){
	$sql="SELECT SUM(cantidad * costoUnitario) AS salidaDomingo FROM salida WHERE WEEK(fecha) = WEEK(NOW()) AND DAYOFWEEK(fecha) =8;";
	return ejecutarConsulta($sql);
}

public function comprasultimos_10dias(){
	$sql=" SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) AS fecha, SUM(total_compra) AS total 
    FROM ingreso GROUP BY fecha_hora ORDER BY fecha_hora DESC LIMIT 0,10";
	return ejecutarConsulta($sql);
}

public function ventasultimos_12meses(){
	$sql=" SELECT DATE_FORMAT(fecha_hora,'%M') AS fecha, SUM(total_venta) AS total FROM venta 
    GROUP BY MONTH(fecha_hora) ORDER BY fecha_hora DESC LIMIT 0,12";
	return ejecutarConsulta($sql);
}


}

 ?>
