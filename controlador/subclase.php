<?php 
require_once "../modelos/Subclase.php";

$subclase=new SubClase();

$idSubclase=isset($_POST["idSubclase"])? limpiarCadena($_POST["idSubclase"]):"";
$idClase=isset($_POST["idClase"])? limpiarCadena($_POST["idClase"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]) {

       
        case 'guardar':
		$rspta=$subclase->insertar($idClase,$nombre);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        break;
	
        case 'editar':
         $rspta=$subclase->editar($idSubclase,$idClase,$nombre);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	
		break;
	

	case 'desactivar':
		$rspta=$subclase->desactivar($idSubclase);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
		
	case 'activar':
		$rspta=$subclase->activar($idSubclase);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$subclase->mostrar($idSubclase);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$subclase->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
                "0"=>$reg->idSubclase,
                "1"=>$reg->clase,
                "2"=>$reg->nombre,
                "3"=>($reg->estado)?'<span class="badge badge-success">Activado</span>':'<span class="badge badge-danger">Desactivado</span>',
                "4"=>($reg->estado)?
                '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idSubclase . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="desactivar" class="btn btn-danger btn-xs" onclick="confirmarEliminacion(' . $reg->idSubclase . ')">
					<i class="fa fa-window-close"></i>
                </button>' :

                    '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idSubclase . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="activar" class="btn btn-primary btn-xs" onclick="confirmarActivacion(' . $reg->idSubclase . ')">
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

		case 'selectClase':
			require_once "../modelos/Clase.php";
			$clase=new Clase();

			$rspta=$clase->select();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idClase.'>'.$reg->nombre.'</option>';
			}
			break;
}
 ?>