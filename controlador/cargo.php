<?php 
require_once "../modelos/Cargo.php";

$cargo=new Cargo();

$idCargo=isset($_POST["idCargo"])? limpiarCadena($_POST["idCargo"]):"";
$idArea=isset($_POST["idArea"])? limpiarCadena($_POST["idArea"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
    
	
        case 'guardar':
		$rspta=$cargo->insertar($idArea,$nombre);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        break;
	
        case 'editar':
         $rspta=$cargo->editar($idCargo,$idArea,$nombre);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		break;
	

	case 'desactivar':
		$rspta=$cargo->desactivar($idCargo);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$cargo->activar($idCargo);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$cargo->mostrar($idCargo);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$cargo->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
                "0"=>$reg->idCargo,
                "1"=>$reg->area,
                "2"=>$reg->nombre,
				"3"=>$reg->created_at,
				"4"=>$reg->updated_at,
                "5"=>($reg->estado)?'<span class="badge badge-success">Activado</span>':'<span class="badge badge-danger">Desactivado</span>',
                "6"=>($reg->estado)?
				'<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idCargo . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="desactivar" class="btn btn-danger btn-xs" onclick="confirmarEliminacion(' . $reg->idCargo . ')">
					<i class="fa fa-window-close"></i>
                </button>' :

                    '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idCargo . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="activar" class="btn btn-primary btn-xs" onclick="confirmarActivacion(' . $reg->idCargo . ')">
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

		case 'selectArea':
			require_once "../modelos/Area.php";
			$area=new Area();

			$rspta=$area->select();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idArea.'>'.$reg->nombre.'</option>';
			}
			break;
}
 ?>