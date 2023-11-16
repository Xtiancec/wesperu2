<?php 
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Usuario{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($idEmpleado,$login,$clave,$permisos){
	$sql="INSERT INTO usuario (idEmpleado,login,clave,estado) 
    VALUES ('$idEmpleado','$login','$clave','1')";
	//return ejecutarConsulta($sql);

	 $idusuarionew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($permisos)) {

	 	$sql_detalle="INSERT INTO usuario_permiso (idusuario,idpermiso) VALUES('$idusuarionew','$permisos[$num_elementos]')";

	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
}

public function editar($idUsuario,$idEmpleado,$login,$clave,$permisos){
	$sql="UPDATE usuario SET 
    idEmpleado='$idEmpleado',
    login='$login',
    clave='$clave',
	WHERE idUsuario='$idUsuario'";
	 ejecutarConsulta($sql);



	 //eliminar permisos asignados
	 $sqldel="DELETE FROM usuario_permiso WHERE idUsuario='$idUsuario'";
	 ejecutarConsulta($sqldel);

	    $num_elementos=0;
	    $sw=true;
	 while ($num_elementos < count($permisos)) {

	 	$sql_detalle="INSERT INTO usuario_permiso (idUsuario,idPermiso) VALUES('$idUsuario','$permisos[$num_elementos]')";

	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;
	 }
	 return $sw;
}

public function desactivar($idUsuario){
	$sql="UPDATE usuario SET estado='0' WHERE idUsuario='$idUsuario'";
	return ejecutarConsulta($sql);
}
public function activar($idUsuario){
	$sql="UPDATE usuario SET estado='1' WHERE idUsuario='$idUsuario'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($idUsuario){
	$sql="SELECT * FROM usuario WHERE idUsuario='$idUsuario'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT 
	usuario.idUsuario,
	usuario.login, 
	CONCAT(empleado.nombre,' ',empleado.apellidoPaterno,' ',empleado.apellidoMaterno) AS empleado,
	usuario.estado
	FROM usuario
	INNER JOIN empleado ON empleado.idEmpleado=usuario.idEmpleado";
	return ejecutarConsulta($sql);
}

//metodo para listar permmisos marcados de un usuario especifico
public function listarmarcados($idUsuario){
	$sql="SELECT * FROM usuario_permiso WHERE idUsuario='$idUsuario'";
	return ejecutarConsulta($sql);
}

//funcion que verifica el acceso al sistema

public function verificar($login, $clave) {

    $sql = "SELECT idUsuario, login FROM usuario WHERE login='$login' AND clave='$clave' AND estado='1'";
    return ejecutarConsulta($sql);
}

public function obtenerNombreEmpleado($idUsuario) {
    $sql = "SELECT CONCAT(nombre, ' ', apellidoPaterno, ' ', apellidoMaterno) AS nombreCompleto
            FROM empleado
            WHERE idEmpleado = (SELECT idEmpleado FROM usuario WHERE idUsuario = '$idUsuario')";
    $result = ejecutarConsultaSimpleFila($sql);

    return isset($result['nombreCompleto']) ? $result['nombreCompleto'] : '';
}
}


 ?>
