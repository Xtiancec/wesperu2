<?php
require_once "../modelos/Requerimiento.php";
if (strlen(session_id()) < 1)
    session_start();

$requerimiento = new Requerimiento();

$idRequerimiento = isset($_POST["idRequerimiento"]) ? limpiarCadena($_POST["idRequerimiento"]) : "";
$idOT = isset($_POST["idOT"]) ? limpiarCadena($_POST["idOT"]) : "";
$idUsuario = $_SESSION["idUsuario"];
$idTipoSalida = isset($_POST["idTipoSalida"]) ? limpiarCadena($_POST["idTipoSalida"]) : "";
$correlativo = isset($_POST["correlativo"]) ? limpiarCadena($_POST["correlativo"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";

// Define el estado del requerimiento en función del estado de autorización de la existencia


switch ($_GET["op"]) {       
    
    case 'guardaryeditar':
        if (empty($idRequerimiento)) {
            
            // Llamar a la función insertar con el estado calculado
            $rspta = $requerimiento->insertar(
                $idOT,
                $idUsuario,
                $idTipoSalida,
                $correlativo,
                $fecha,
                $_POST["idExistencia"],
                $_POST["stockSolicitado"],
                $estado
            );
            if ($rspta) {
                echo "Datos registrados correctamente";
            } else {
                echo "Error al registrar los datos: " . mysqli_error($conexion); // Suponiendo que hay un método obtenerError() implementado en tu clase.
            }

            echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        } else {
        }
        break;

        
    case 'listarExistencias':
        require_once "../modelos/Existencia.php";
        $existencia = new Existencia();

        $rspta = $existencia->listarActivos();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => ' <div class="d-flex align-items-center justify-content-center"><button class="btn btn-success" onclick="agregarDetalle(' . $reg->idExistencia . ',\'' . $reg->nombre . '\')"><span class="fa fa-plus"></span></button></div>',
                "1" => $reg->clase,
                "2" => $reg->subclase,
                "3" => $reg->nombre,
                "4" => $reg->stockActual,
                "5" => $reg->um,
                "6" => $reg->autorizacion,
            );
        }

        $results = array(
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);

        break;

    case 'editar':
        if (empty($idRequerimiento)) {
            $rspta = $requerimiento->insertar(
                $idRequerimiento,
                $idOT,
                $idUsuario,
                $idTipoSalida,
                $correlativo,
                $fecha,
                $_POST["idExistencia"],
                $_POST["stockSolicitado"]
            );
            echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        }
        break;


    case 'anular':
        $rspta = $requerimiento->anular($idRequerimiento);
        echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
        break;

    case 'mostrar':
        $rspta = $requerimiento->mostrar($idRequerimiento);
        echo json_encode($rspta);
        break;


    case 'listarDetalle':
        $id = $_GET['id'];

        $rspta = $requerimiento->listarDetalle($id);
        $total = 0;
        $item=0;
        echo '<thead style="background-color:#A9D0F5">
			<th>Eliminar</th>
			<th>Existencia</th>
			<th>stockSolicitado</th>
			<th>Opciones</th>
			</thead>';

        while ($reg = $rspta->fetch_object()) {
            $item++; 
            echo '<tr class="filas">
				<td>'.$item.'</td>
				<td>' . $reg->existencia . '</td>
				<td>' . $reg->stockSolicitado . '</td>
				<td></td>
				</tr>';
        }

        echo '<tfoot>
			<th></th>
			<th></th>
			<th></th>
			<th></th>';
        break;

        case 'obtenerUltimaSecuenciaPorTipoSalida':
            $idTipoSalida = $_GET['idTipoSalida'];
            $ultimaSecuencia = $requerimiento->obtenerUltimaSecuenciaPorTipoSalida($idTipoSalida);
            $letraTipoSalida = $requerimiento->obtenerLetraTipoSalida($idTipoSalida);
            $correlativoGenerado = $requerimiento->generarCorrelativo($letraTipoSalida, $ultimaSecuencia);
        
            $respuesta = [
                'letra' => $letraTipoSalida,
                'ultimaSecuencia' => $ultimaSecuencia
            ];
        
            echo json_encode($respuesta);
            break;
            case 'listarporautorizar':
                $rspta = $requerimiento->listarporautorizar();
                $data = array();
                while ($reg = $rspta->fetch_object()) {
                    $data[] = array(
        
                        "0" => $reg->fecha,
                        "1" => $reg->correlativo,
                        "2" => $reg->ot,
                        "3" => $reg->usuario,
                        "4" => $reg->tipoSalida,
                        "5" => $reg->estado,
                        "6" => ($reg->estado == 'Pendiente de Aprobación') ?
                            '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idRequerimiento . ')"><i class="fa fa-eye"></i></button>' . ' ' .
                            '<button class="btn btn-danger btn-xs" onclick="anular(' . $reg->idRequerimiento . ')"><i class="fa fa-close"></i></button>' :
                            '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idRequerimiento . ')"><i class="fa fa-eye"></i></button>',
        
                    );
                }
                $results = array(
                    "sEcho" => 1, //info para datatables
                    "iTotalRecords" => count($data), //enviamos el total de registros al datatable
                    "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                    "aaData" => $data
                );
                echo json_encode($results);
                break;
            
    case 'listar':
        $rspta = $requerimiento->listar();
        $data = array();
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(

                "0" => $reg->fecha,
                "1" => $reg->correlativo,
                "2" => $reg->ot,
                "3" => $reg->usuario,
                "4" => $reg->empleado,
                "5" => $reg->tipoSalida,
                "6" => $reg->estado,
                "7" => ($reg->estado == 'Pendiente de Aprobación') ?
                    '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idRequerimiento . ')"><i class="fa fa-eye"></i></button>' . ' ' .
                    '<button class="btn btn-danger btn-xs" onclick="anular(' . $reg->idRequerimiento . ')"><i class="fa fa-close"></i></button>' :
                    '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idRequerimiento . ')"><i class="fa fa-eye"></i></button>',

            );
        }
        $results = array(
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($data), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;



    case 'selectExistencia':
        require_once "../modelos/Existencia.php";
        $existencia = new Existencia();

        $rspta = $existencia->listarActivos();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idExistencia . '>' . $reg->nombre . '</option>';
        }
        break;



    case 'selectOT':
        require_once "../modelos/OT.php";
        $ot = new OT();

        $rspta = $ot->listar();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idOT . '>' . $reg->numero . '</option>';
        }
        break;

    case 'selectTipoSalida':
        require_once "../modelos/TipoSalida.php";
        $tiposalida = new TipoSalida();

        $rspta = $tiposalida->select();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idTiposalida . '>' . $reg->nombre . '</option>';
        }
        break;
}
