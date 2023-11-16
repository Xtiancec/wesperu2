<?php 
require_once "../modelos/OT.php";

$ot=new OT();

$idOT=isset($_POST["idOT"])? limpiarCadena($_POST["idOT"]):"";
$idEmpresa=isset($_POST["idEmpresa"])? limpiarCadena($_POST["idEmpresa"]):"";
$idAlmacen=isset($_POST["idAlmacen"])? limpiarCadena($_POST["idAlmacen"]):"";
$numero=isset($_POST["numero"])? limpiarCadena($_POST["numero"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$fechaInicio=isset($_POST["fechaInicio"])? limpiarCadena($_POST["fechaInicio"]):"";
$fechaFin=isset($_POST["fechaFin"])? limpiarCadena($_POST["fechaFin"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";

switch ($_GET["op"]) {

       
        case 'guardar':
		$rspta=$ot->insertar($idEmpresa,$idAlmacen,$numero,$descripcion,$fechaInicio,$fechaFin,$estado);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        break;
	
        case 'editar':
         $rspta=$ot->editar($idOT,$idEmpresa,$idAlmacen,$numero,$descripcion,$fechaInicio,$fechaFin,$estado);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	
		break;
	


	
	case 'mostrar':
		$rspta=$ot->mostrar($idOT);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$ot->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
                "0"=>$reg->idOT,
                "1"=>$reg->empresa,
                "2"=>$reg->almacen,
                "3"=>$reg->numero,
                "4"=>$reg->descripcion,
                "5"=>$reg->fechaInicio,
                "6"=>$reg->fechaFin,
                "7"=>$reg->estado      
            );
		}
		
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectEmpresa':
			require_once "../modelos/Empresa.php";
			$empresa=new Empresa();

			$rspta=$empresa->listarClientes();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idEmpresa.'>'.$reg->nombre.'</option>';
			}
			break;

            case 'selectAlmacen':
                require_once "../modelos/Almacen.php";
                $almacen=new Almacen();    
                $rspta=$almacen->select();
    
                while ($reg=$rspta->fetch_object()) {
                    echo '<option value=' . $reg->idAlmacen.'>'.$reg->nombre.'</option>';
                }
                break;

        }
 ?>