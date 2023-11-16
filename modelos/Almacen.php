<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";

class Almacen
{
	public function insertar($nombre, $direccion)
	{
		$sql = "INSERT INTO almacenes (nombre,direccion,estado) VALUES ('$nombre','$direccion','1')";
		return ejecutarConsulta($sql);
	}

	public function editar($idAlmacen, $nombre, $direccion)
	{
		$sql = "UPDATE almacenes SET nombre='$nombre',direccion='$direccion' 
	WHERE idAlmacen='$idAlmacen'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idAlmacen)
	{
		$sql = "UPDATE almacenes SET estado='0' WHERE idAlmacen='$idAlmacen'";
		return ejecutarConsulta($sql);
	}
	public function activar($idAlmacen)
	{
		$sql = "UPDATE almacenes SET estado='1' WHERE idAlmacen='$idAlmacen'";
		return ejecutarConsulta($sql);
	}

	//metodo para mostrar registros
	public function mostrar($idAlmacen)
	{
		$sql = "SELECT * FROM almacenes WHERE idAlmacen='$idAlmacen'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	//listar registros
	public function listar()
	{
		$sql = "SELECT * FROM almacenes";
		return ejecutarConsulta($sql);
	}


	//listar y mostrar en select
	public function select()
	{
		$sql = "SELECT idAlmacen, nombre FROM almacenes WHERE estado=1";
		return ejecutarConsulta($sql);
	}
}
