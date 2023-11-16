<?php 
require_once "../modelos/Area.php";

$area=new Area();

$idArea=isset($_POST["idArea"])? limpiarCadena($_POST["idArea"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";


switch ($_GET["op"]) {
 
	

	case 'guardar':
	
		$rspta=$area->insertar($nombre);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	break;

	case 'editar':
         $rspta=$area->editar($idArea,$nombre);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	
		break;


	

	case 'desactivar':
		$rspta=$area->desactivar($idArea);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$area->activar($idArea);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$area->mostrar($idArea);
		echo json_encode($rspta);
		break;

		

		

    case 'listar':
		$rspta=$area->listar();
		$data=Array();
        
		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>$reg->idArea,
            "1"=>$reg->nombre,
			"2"=>$reg->created_at,
			"3"=>$reg->updated_at,

            "4"=>($reg->estado)?'<span class="badge badge-success">Activado</span>':'<span class="badge badge-danger">Desactivado</span>',
            "5"=>($reg->estado)?
            '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idArea . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="desactivar" class="btn btn-danger btn-xs" onclick="confirmarEliminacion(' . $reg->idArea . ')">
					<i class="fa fa-window-close"></i>
                </button>' :

                    '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idArea . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="activar" class="btn btn-primary btn-xs" onclick="confirmarActivacion(' . $reg->idArea . ')">
                    <i class="fa fa-check-square"></i>
                    </button>',
           
        );
		}
		$results=array(
             "aaData"=>$data); 
		echo json_encode($results);
		break;
}
 ?>