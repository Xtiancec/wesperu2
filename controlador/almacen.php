<?php 
require_once "../modelos/Almacen.php";

$almacen=new Almacen();

$idAlmacen=isset($_POST["idAlmacen"])? limpiarCadena($_POST["idAlmacen"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";


switch ($_GET["op"]) {

	case 'guardar':
		$rspta=$almacen->insertar($nombre,$direccion);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		break;
	
	case 'editar':
         $rspta=$almacen->editar($idAlmacen,$nombre,$direccion);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		break;

	case 'desactivar':
		$rspta=$almacen->desactivar($idAlmacen);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;
	case 'activar':
		$rspta=$almacen->activar($idAlmacen);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;
	
	case 'mostrar':
		$rspta=$almacen->mostrar($idAlmacen);
		echo json_encode($rspta);
		break;

   case 'listar':
		$rspta=$almacen->listar();
		$data=Array();
        
		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>$reg->idAlmacen,
            "1"=>$reg->nombre,
            "2"=>$reg->direccion,
            "3"=>($reg->estado)?'<span class="badge badge-success">Activado</span>':'<span class="badge badge-danger">Desactivado</span>',
            "4"=>($reg->estado)?
            '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idAlmacen . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="desactivar" class="btn btn-danger btn-xs" onclick="confirmarEliminacion(' . $reg->idAlmacen . ')">
					<i class="fa fa-window-close"></i>
                </button>' :

                    '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idAlmacen . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="activar" class="btn btn-primary btn-xs" onclick="confirmarActivacion(' . $reg->idAlmacen . ')">
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