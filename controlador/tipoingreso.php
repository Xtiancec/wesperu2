<?php 
require_once "../modelos/TipoIngreso.php";

$tipoingreso=new TipoIngreso();

$idTipoingreso=isset($_POST["idTipoingreso"])? limpiarCadena($_POST["idTipoingreso"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";


switch ($_GET["op"]) {
	case 'guardar':
	
		$rspta=$tipoingreso->insertar($nombre);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		break;

	case 'editar':
         $rspta=$tipoingreso->editar($idTipoingreso,$nombre);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	
		break;


	
	case 'desactivar':
		$rspta=$tipoingreso->desactivar($idTipoingreso);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$tipoingreso->activar($idTipoingreso);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$tipoingreso->mostrar($idTipoingreso);
		echo json_encode($rspta);
		break;

		

		

    case 'listar':
		$rspta=$tipoingreso->listar();
		$data=Array();
        
		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>$reg->idTipoingreso,
            "1"=>$reg->nombre,
            "2"=>($reg->estado)?'<span class="badge badge-success">Activado</span>':'<span class="badge badge-danger">Desactivado</span>',
            "3"=>($reg->estado)?
            '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idTipoingreso . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="desactivar" class="btn btn-danger btn-xs" onclick="confirmarEliminacion(' . $reg->idTipoingreso . ')">
					<i class="fa fa-window-close"></i>
                </button>' :

                    '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idTipoingreso . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="activar" class="btn btn-primary btn-xs" onclick="confirmarActivacion(' . $reg->idTipoingreso . ')">
                    <i class="fa fa-check-square"></i>
                    </button>',
           
        );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;
        
}
 ?>