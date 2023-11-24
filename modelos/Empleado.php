<?php
//incluir la conexion de base de datos
require "../config/Conexion.php";
class Empleado
{
    //implementamos nuestro constructor
    public function __construct()
    {
    }

    //metodo insertar regiustro
    public function insertar(
        $idCargo,
        $idBanco,
        $tipoDocumento,
        $numeroDocumento,
        $nombre,
        $apellidoPaterno,
        $apellidoMaterno,
        $telefono,
        $personaContacto,
        $telefonoEmergencia,
        $correo,
        $direccion,
        $distrito,
        $fechaNacimiento,
        $fechaIngreso,
        $tipoSeguro,
        $fechaSeguroVida,
        $numeroCuenta,
        $informacionAdicional,
        $estado
    ) {
        $sql = "INSERT INTO empleado (idCargo,idBanco,tipoDocumento,numeroDocumento,nombre,apellidoPaterno,apellidoMaterno,
    telefono,personaContacto,telefonoEmergencia,correo,direccion,distrito,fechaNacimiento,
    fechaIngreso,tipoSeguro,fechaSeguroVida,numeroCuenta,informacionAdicional,estado)
    
	 VALUES ('$idCargo','$idBanco','$tipoDocumento','$numeroDocumento','$nombre','$apellidoPaterno','$apellidoMaterno',
     '$telefono','$personaContacto','$telefonoEmergencia','$correo',
     '$direccion','$distrito','$fechaNacimiento','$fechaIngreso','$tipoSeguro','$fechaSeguroVida','$numeroCuenta','$informacionAdicional','$estado')";
        return ejecutarConsulta($sql);
    }

    public function editar(
        $idEmpleado,
        $idCargo,
        $idBanco,
        $tipoDocumento,
        $numeroDocumento,
        $nombre,
        $apellidoPaterno,
        $apellidoMaterno,
        $telefono,
        $personaContacto,
        $telefonoEmergencia,
        $correo,
        $direccion,
        $distrito,
        $fechaNacimiento,
        $fechaIngreso,
        $tipoSeguro,
        $fechaSeguroVida,
        $numeroCuenta,
        $informacionAdicional,
        $estado
    ) {
        $sql = "UPDATE empleado SET 
     idEmpleado='$idEmpleado',
     idCargo='$idCargo',
     idBanco='$idBanco',
     tipoDocumento='$tipoDocumento',
     numeroDocumento='$numeroDocumento',
     nombre='$nombre',
     apellidoPaterno='$apellidoPaterno',
     apellidoMaterno='$apellidoMaterno',
     telefono='$telefono',
     personaContacto='$personaContacto',
     telefonoEmergencia='$telefonoEmergencia',
     correo='$correo',
     direccion='$direccion',
     distrito=''$distrito,
     fechaNacimiento='$fechaNacimiento',
     fechaIngreso='$fechaIngreso',
     tipoSeguro='$tipoSeguro',
     fechaSeguroVida='$fechaSeguroVida',
     numeroCuenta='$numeroCuenta',
     informacionAdicional='$informacionAdicional',
     estado='$estado'

	WHERE idEmpleado='$idEmpleado'";
        return ejecutarConsulta($sql);
    }


    //metodo para mostrar registros
    public function mostrar($idEmpleado)
    {
        $sql = "SELECT * FROM empleado WHERE idEmpleado='$idEmpleado'";
        return ejecutarConsultaSimpleFila($sql);
    }

    //listar registros 
    public function listar()
    {
        $sql = "SELECT 
    empleado.idEmpleado,
    empleado.idCargo,
    empleado.idBanco,
    cargo.nombre as cargo,
    banco.nombre as banco,
    empleado.tipoDocumento,
    empleado.numeroDocumento,
    CONCAT(empleado.apellidoPaterno,' ',empleado.apellidoMaterno,' ',empleado.nombre) AS nombre,
    empleado.telefono,
    empleado.direccion,
    empleado.fechaIngreso,
    empleado.fechaNacimiento,
    empleado.tipoSeguro,
    empleado.fechaSeguroVida,
    empleado.numeroCuenta,
    empleado.informacionAdicional,
    empleado.estado
    
    FROM empleado
    inner join banco on banco.idBanco=empleado.idBanco
    inner join cargo on cargo.idCargo=empleado.idCargo";
        return ejecutarConsulta($sql);
    }

    //listar registros activos
    public function listarActivos()
    {
        $sql = "SELECT 
    empleado.idEmpleado,
    empleado.idCargo,
    empleado.idBanco,
    cargo.nombre as cargo,
    banco.nombre as banco,
    empleado.tipoDocumento,
    empleado.numeroDocumento,
    CONCAT(empleado.apellidoPaterno,' ',empleado.apellidoMaterno,' ',empleado.nombre) AS nombre,
    empleado.telefono,
    empleado.direccion,
    empleado.fechaIngreso,
    empleado.numeroCuenta,
    empleado.informacionAdicional
   
    
    FROM empleado
    inner join banco on banco.idBanco=empleado.idBanco
    inner join cargo on cargo.idCargo=empleado.idCargo
    
    WHERE empleado.estado='LABORANDO'";

        return ejecutarConsulta($sql);
    }

    //implementar un metodo para listar los activos, su ultimo precio y el stock(vamos a unir con el ultimo registro de la tabla detalle_ingreso)

}
