<?php
require_once "../modelos/Existencia.php";

$existencia = new Existencia();

$idExistencia = isset($_POST["idExistencia"]) ? limpiarCadena($_POST["idExistencia"]) : "";
$idSubclase = isset($_POST["idSubclase"]) ? limpiarCadena($_POST["idSubclase"]) : "";
$idUM = isset($_POST["idUM"]) ? limpiarCadena($_POST["idUM"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$stockActual = isset($_POST["stockInicial"]) ? limpiarCadena($_POST["stockInicial"]) : "";
$precioActual = isset($_POST["precioActual"]) ? limpiarCadena($_POST["precioActual"]) : "";
$autorizacion = isset($_POST["autorizacion"]) ? limpiarCadena($_POST["autorizacion"]) : "";

switch ($_GET["op"]) {

    case 'guardar':
        $rspta = $existencia->insertar($idSubclase, $idUM, $nombre, $stockActual, $precioActual,$autorizacion);
        echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        break;

    case 'editar':
        $rspta = $existencia->editar($idExistencia, $idSubclase, $idUM, $nombre,$autorizacion);
        echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";

        break;


    case 'desactivar':
        $rspta = $existencia->desactivar($idExistencia);
        echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
        break;
    case 'activar':
        $rspta = $existencia->activar($idExistencia);
        echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
        break;

    case 'mostrar':
        $rspta = $existencia->mostrar($idExistencia);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $existencia->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->idExistencia,
                "1" => $reg->clase,
                "2" => $reg->subclase,
                "3" => $reg->nombre,
                "4" => $reg->um,
                "5" => $reg->stockActual,
                "6" => $reg->precioActual,
                "7" => ($reg->estado) ? '<span class="badge badge-success">Activado</span>' : '<span class="badge badge-danger">Desactivado</span>',
                "8" => ($reg->estado) ?
                '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idExistencia . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="sa-params" class="btn btn-danger btn-xs" onclick="confirmarEliminacion(' . $reg->idExistencia . ')">
                <i class="fa fa-window-close"></i>
                </button>' :

                    '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idExistencia . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button class="btn btn-primary btn-xs" onclick="confirmarAcivacion(' . $reg->idExistencia . ')">
                    <i class="fa fa-check-square"></i>
                    </button>',

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

    case 'selectSubclase':
        require_once "../modelos/Subclase.php";
        $subclase = new SubClase();

        $rspta = $subclase->listarActivos();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idSubclase . '>' . $reg->nombre . '</option>';
        }
        break;

    case 'selectUM':
        require_once "../modelos/UM.php";
        $um = new UM();

        $rspta = $um->select();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idUM . '>' . $reg->nombre . '</option>';
        }
        break;


}
