<?php
require_once "../modelos/Salida.php";

$salida = new Salida();

$idSalida = isset($_POST["idSalida"]) ? limpiarCadena($_POST["idSalida"]) : "";
$idExistencia = isset($_POST["idExistencia"]) ? limpiarCadena($_POST["idExistencia"]) : "";
$idTiposalida = isset($_POST["idTiposalida"]) ? limpiarCadena($_POST["idTiposalida"]) : "";
$idOT = isset($_POST["idOT"]) ? limpiarCadena($_POST["idOT"]) : "";
$idEmpleado = isset($_POST["idEmpleado"]) ? limpiarCadena($_POST["idEmpleado"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";
$cantidad = isset($_POST["cantidad"]) ? limpiarCadena($_POST["cantidad"]) : "";
$costoUnitario = isset($_POST["costoUnitario"]) ? limpiarCadena($_POST["costoUnitario"]) : "";
$subTotal = isset($_POST["subTotal"]) ? limpiarCadena($_POST["subTotal"]) : "";

switch ($_GET["op"]) {

    case 'guardar':
        $rspta = $salida->insertar($idExistencia, $idTiposalida, $idOT, $idEmpleado, $fecha, $cantidad, $costoUnitario, $subTotal);
        echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        break;

    case 'editar':
        $rspta = $salida->editar($idSalida, $idExistencia, $idTiposalida, $idOT, $idEmpleado, $fecha, $cantidad, $costoUnitario, $subTotal);
        echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
        break;

    case 'mostrar':
        $rspta = $salida->mostrar($idSalida);
        echo json_encode($rspta);
        break;

    case 'calcularCostoReal':
        $idExistencia = $_POST['idExistencia'];
        $cantidadDeseada = floatval($_POST['cantidad']); // Convierte a número
        $costoUnitario = $salida->calcularCostoReal($idExistencia, $cantidadDeseada);
        echo json_encode(array("costoUnitario" => $costoUnitario));
        break;

    case 'calcularPrecioUltimo':
        $rspta = $salida->calcularPrecioUltimo($idExistencia);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $salida->listar();
        $data = array();
        $total = 0;

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->idSalida,
                "1" => $reg->almacen,
                "2" => $reg->ot,
                "3" => $reg->tipoSalida,
                "4" => $reg->fecha,
                "5" => $reg->existencia,
                "6" => $reg->cantidad,
                "7" => $reg->costoUnitario,
                "8" => $reg->subTotal,
                "9" => $reg->empleado,
                "10" => ($reg->subTotal) ?
                    '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idSalida . ')">
                <i class="far fa-edit"></i>
                </button>' . ' '
                    :
                    '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idSalida . ')">
                <i class="far fa-edit"></i>
                </button>',
            );
        }

        $results = array(
            "sEcho" => 1, // info para datatables
            "iTotalRecords" => count($data), // enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($data), // enviamos el total de registros a visualizar
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'selectExistencia':
        require_once "../modelos/Existencia.php";
        $existencia = new Existencia();

        $rspta = $existencia->listarActivos();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idExistencia . '>' . $reg->nombre . '\' 
            | Precio Actual: S/.' . $reg->precioActual . '\' 
            | Stock:' . $reg->stockActual . '\' ' . $reg->um . '</option>';
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

    case 'selectOT':
        require_once "../modelos/OT.php";
        $ot = new OT();

        $rspta = $ot->listar();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idOT . '>' . $reg->numero . '</option>';
        }
        break;

    case 'selectEmpleado':
        require_once "../modelos/Empleado.php";
        $empleado = new Empleado();

        $rspta = $empleado->listarActivos();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idEmpleado . '>' . $reg->nombre . '</option>';
        }
        break;
}
