<?php 
require_once "../modelos/Empleado.php";

$empleado=new Empleado();

$idEmpleado=isset($_POST["idEmpleado"])? limpiarCadena($_POST["idEmpleado"]):"";
$idCargo=isset($_POST["idCargo"])? limpiarCadena($_POST["idCargo"]):"";
$idBanco=isset($_POST["idBanco"])? limpiarCadena($_POST["idBanco"]):"";
$tipoDocumento=isset($_POST["tipoDocumento"])? limpiarCadena($_POST["tipoDocumento"]):"";
$numeroDocumento=isset($_POST["numeroDocumento"])? limpiarCadena($_POST["numeroDocumento"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellidoPaterno=isset($_POST["apellidoPaterno"])? limpiarCadena($_POST["apellidoPaterno"]):"";
$apellidoMaterno=isset($_POST["apellidoMaterno"])? limpiarCadena($_POST["apellidoMaterno"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$personaContacto=isset($_POST["personaContacto"])? limpiarCadena($_POST["personaContacto"]):"";
$telefonoEmergencia=isset($_POST["telefonoEmergencia"])? limpiarCadena($_POST["telefonoEmergencia"]):"";
$correo=isset($_POST["correo"])? limpiarCadena($_POST["correo"]):"";
$direccion=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$distrito=isset($_POST["distrito"])? limpiarCadena($_POST["distrito"]):"";

$fechaNacimiento=isset($_POST["fechaNacimiento"])? limpiarCadena($_POST["fechaNacimiento"]):"";
$fechaIngreso=isset($_POST["fechaIngreso"])? limpiarCadena($_POST["fechaIngreso"]):"";
$tipoSeguro=isset($_POST["tipoSeguro"])? limpiarCadena($_POST["tipoSeguro"]):"";
$fechaSeguroVida=isset($_POST["fechaSeguroVida"])? limpiarCadena($_POST["fechaSeguroVida"]):"";
$numeroCuenta=isset($_POST["numeroCuenta"])? limpiarCadena($_POST["numeroCuenta"]):"";
$informacionAdicional=isset($_POST["informacionAdicional"])? limpiarCadena($_POST["informacionAdicional"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";

switch ($_GET["op"]) {
	
        case 'guardar':
		$rspta=$empleado->insertar($idCargo,$idBanco,$tipoDocumento,$numeroDocumento,$nombre,$apellidoPaterno,$apellidoMaterno,
        $telefono,$personaContacto,$telefonoEmergencia,$correo,$direccion,$distrito,$fechaNacimiento,$fechaIngreso,$tipoSeguro,$fechaSeguroVida,
        $numeroCuenta,$informacionAdicional,$estado);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        break;
	
        case 'editar':
         $rspta=$empleado->editar($idEmpleado,$idCargo,$idBanco,$tipoDocumento,$numeroDocumento,$nombre,$apellidoPaterno,$apellidoMaterno,
         $telefono,$personaContacto,$telefonoEmergencia,$correo,$direccion,$distrito,$fechaNacimiento,$fechaIngreso,$tipoSeguro,$fechaSeguroVida,
         $numeroCuenta,$informacionAdicional,$estado);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";

		break;
	
	case 'mostrar':
		$rspta=$empleado->mostrar($idEmpleado);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$empleado->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
                "0"=>$reg->idEmpleado,
                "1"=>$reg->cargo,
                "2"=>$reg->tipoDocumento,
                "3"=>$reg->numeroDocumento,
                "4"=>$reg->nombre,
                "5"=>$reg->telefono,
                "6"=>$reg->direccion,
                "7"=>$reg->fechaIngreso,
                "8"=>$reg->banco,
                "9"=>$reg->numeroCuenta,
                "10"=>($reg->estado)?'<span class="badge badge-success">LABORANDO</span>':'<span class="badge badge-danger">DE BAJA</span>',
                
            );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectBanco':
			require_once "../modelos/Banco.php";
			$banco=new Banco();

			$rspta=$banco->select();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idBanco.'>'.$reg->nombre.'</option>';
			}
			break;

        case 'selectCargo':
            require_once "../modelos/Cargo.php";
            $cargo=new Cargo();
    
            $rspta=$cargo->listarActivos();
    
            while ($reg=$rspta->fetch_object()) {
                echo '<option value=' . $reg->idCargo.'>'.$reg->nombre.'</option>';
             }
             break;
}
