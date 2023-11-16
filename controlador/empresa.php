<?php
require_once "../modelos/Empresa.php";

$empresa = new Empresa();

$idEmpresa = isset($_POST["idEmpresa"]) ? limpiarCadena($_POST["idEmpresa"]) : "";
$idBanco = isset($_POST["idBanco"]) ? limpiarCadena($_POST["idBanco"]) : "";
$tipoEmpresa = isset($_POST["tipoEmpresa"]) ? limpiarCadena($_POST["tipoEmpresa"]) : "";
$nombre = isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]) : "";
$RUC = isset($_POST["RUC"]) ? limpiarCadena($_POST["RUC"]) : "";
$numeroDocumento = isset($_POST["numeroDocumento"]) ? limpiarCadena($_POST["numeroDocumento"]) : "";

$direccion = isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]) : "";
$estados = isset($_POST["estados"]) ? limpiarCadena($_POST["estados"]) : "";
$condicion = isset($_POST["condicion"]) ? limpiarCadena($_POST["condicion"]) : "";
$departamento = isset($_POST["departamento"]) ? limpiarCadena($_POST["departamento"]) : "";
$provincia = isset($_POST["provincia"]) ? limpiarCadena($_POST["provincia"]) : "";
$distrito = isset($_POST["distrito"]) ? limpiarCadena($_POST["distrito"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena($_POST["telefono"]) : "";
$numeroCuenta = isset($_POST["numeroCuenta"]) ? limpiarCadena($_POST["numeroCuenta"]) : "";
$informacionGeneral = isset($_POST["informacionGeneral"]) ? limpiarCadena($_POST["informacionGeneral"]) : "";

switch ($_GET["op"]) {

    case 'guardar':
        $rspta = $empresa->insertar($idBanco, $tipoEmpresa, $nombre, $RUC, $numeroDocumento,$direccion, $estados, $condicion, $departamento, $provincia, $distrito, $telefono, $numeroCuenta, $informacionGeneral);
        echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
        break;

    case 'editar':
        $rspta = $empresa->editar($idEmpresa, $idBanco, $tipoEmpresa, $nombre, $RUC,$numeroDocumento, $direccion, $estados, $condicion, $departamento, $provincia, $distrito, $telefono, $numeroCuenta, $informacionGeneral);
        echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";

        break;

    case 'mostrar':
        $rspta = $empresa->mostrar($idEmpresa);
        echo json_encode($rspta);
        break;

    case 'desactivar':
        $rspta = $empresa->desactivar($idEmpresa);
        echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
        break;

    case 'activar':
        $rspta = $empresa->activar($idEmpresa);
        echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
        break;
        
    case 'selectBanco':
        require_once "../modelos/Banco.php";
        $banco = new Banco();

        $rspta = $banco->select();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value=' . $reg->idBanco . '>' . $reg->nombre . '</option>';
        }
        break;

    case 'listar':
        $rspta = $empresa->listar();
        $data = array();

        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => $reg->idEmpresa,
                "1" => $reg->tipoEmpresa,
                "2" => $reg->numeroDocumento,
                "3" => $reg->nombre,
                "4" => $reg->telefono,
                "5" => $reg->banco,
                "6" => $reg->numeroCuenta,
                "7" => ($reg->estado) ? '<span class="badge badge-success">Activado</span>' : '<span class="badge badge-danger">Desactivado</span>',
                "8" => ($reg->estado) ?

                '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idEmpresa . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="desactivar" class="btn btn-danger btn-xs" onclick="confirmarEliminacion(' . $reg->idEmpresa . ')">
					<i class="fa fa-window-close"></i>
                </button>' :

                    '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idEmpresa . ')"">
                <i class="fa fa-edit"></i>
                </button>' . ' ' .

                    '<button id="activar" class="btn btn-primary btn-xs" onclick="confirmarActivacion(' . $reg->idEmpresa . ')">
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


        case 'listarClientes':
            $rspta = $empresa->listarClientes();
            $data = array();
    
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0" => $reg->idEmpresa,
                    "1" => $reg->tipoEmpresa,
                    "2" => $reg->numeroDocumento,
                    "3" => $reg->nombre,
                    "4" => $reg->telefono,
                    "5" => $reg->banco,
                    "6" => $reg->numeroCuenta,
                    "7" => ($reg->estado) ? '<span class="badge badge-success">Activado</span>' : '<span class="badge badge-danger">Desactivado</span>',
                    "8" => ($reg->estado) ?
    
                        '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idEmpresa . ')">
                    <i class="far fa-edit"></i>
                    </button>' . ' ' .
    
                        '<button class="btn btn-danger warning cancel btn-xs" onclick="confirmarEliminacion(' . $reg->idEmpresa . ')">
                    <i class="far fa-trash-alt"></i>
                    </button>' :
    
                        '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idEmpresa . ')">
                    <i class="far fa-edit"></i>
                    </button>' . ' ' .
    
                        '<button class="btn btn-primary warning cancel btn-xs" onclick="confirmarAcivacion(' . $reg->idEmpresa . ')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
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

            case 'listarProveedores':
                $rspta = $empresa->listarProveedores();
                $data = array();
        
                while ($reg = $rspta->fetch_object()) {
                    $data[] = array(
                        "0" => $reg->idEmpresa,
                        "1" => $reg->tipoEmpresa,
                        "2" => $reg->numeroDocumento,
                        "3" => $reg->nombre,
                        "4" => $reg->telefono,
                        "5" => $reg->banco,
                        "6" => $reg->numeroCuenta,
                        "7" => ($reg->estado) ? '<span class="badge badge-success">Activado</span>' : '<span class="badge badge-danger">Desactivado</span>',
                        "8" => ($reg->estado) ?
        
                            '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idEmpresa . ')">
                        <i class="far fa-edit"></i>
                        </button>' . ' ' .
        
                            '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->idEmpresa . ')">
                        <i class="far fa-trash-alt"></i>
                        </button>' :
        
                            '<button class="btn btn-warning btn-xs"  type="button" data-toggle="modal" data-target="#formularioActualizar" onclick="mostrar(' . $reg->idEmpresa . ')">
                        <i class="far fa-edit"></i>
                        </button>' . ' ' .
        
                            '<button class="btn btn-primary btn-xs" onclick="activar(' . $reg->idEmpresa . ')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
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
}
