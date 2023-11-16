<?php 

require_once "../modelos/UM.php";

$um=new UM();

$idUM=isset($_POST["idUM"])? limpiarCadena($_POST["idUM"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";


switch ($_GET["op"]) {
 
	case 'guardar':
		$rspta=$um->insertar($nombre,$descripcion);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		break;

	case 'editar':
         $rspta=$um->editar($idUM,$nombre,$descripcion);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		break;

	case 'desactivar':
		$rspta=$um->desactivar($idUM);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;

	case 'activar':
		$rspta=$um->activar($idUM);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$um->mostrar($idUM);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$um->listar();
		$data=Array();
		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>$reg->idUM,
            "1"=>$reg->nombre,
            "2"=>$reg->descripcion,
            "3"=>($reg->estado)?'<span class="badge badge-success">Activado</span>':'<span class="badge badge-danger">Desactivado</span>',
            "4"=>($reg->estado)?
            '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idUM . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="desactivar" class="btn btn-danger btn-xs" onclick="confirmarEliminacion(' . $reg->idUM . ')">
					<i class="fa fa-window-close"></i>
                </button>' :

                    '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idUM . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="activar" class="btn btn-primary btn-xs" onclick="confirmarActivacion(' . $reg->idUM . ')">
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