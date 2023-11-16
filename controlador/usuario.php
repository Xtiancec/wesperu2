<?php
session_start();
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

$idUsuario = isset($_POST["idUsuario"]) ? limpiarCadena($_POST["idUsuario"]) : "";
$login = isset($_POST["login"]) ? limpiarCadena($_POST["login"]) : "";
$clave = isset($_POST["clave"]) ? limpiarCadena($_POST["clave"]) : "";

switch ($_GET["op"]) {

	case 'guardar':
		//Hash SHA256 para la contraseña
		$clavehash = hash("SHA256", $clave);
		$rspta = $usuario->insertar($idEmpleado, $login, $clavehash, $_POST['permiso']);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del usuario";
		break;

	case 'editar':
		$clavehash = hash("SHA256", $clave);

		$rspta = $usuario->editar($idUsuario, $idEmpleado, $login, $clavehash, $_POST['permiso']);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";

		break;


	case 'desactivar':
		$rspta = $usuario->desactivar($idUsuario);
		echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
		break;

	case 'activar':
		$rspta = $usuario->activar($idUsuario);
		echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
		break;

	case 'mostrar':
		$rspta = $usuario->mostrar($idUsuario);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $usuario->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => $reg->idUsuario,
				"1" => $reg->login,
				"2" => $reg->empleado,
				"3" => ($reg->estado) ? '<span class="badge badge-success">Activado</span>':'<span class="badge badge-danger">Desactivado</span>',
				"4" => ($reg->idUsuario) ? '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idUsuario . ')"><i class="fa fa-pencil"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $reg->idUsuario . ')"><i class="fa fa-close"></i></button>' : '<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idUsuario . ')"><i class="fa fa-pencil"></i></button>' . ' ' . '<button class="btn btn-primary btn-xs" onclick="activar(' . $reg->idUsuario . ')"><i class="fa fa-check"></i></button>'
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

		case 'permisos':
			// obtenemos todos los permisos de la tabla permisos
			require_once "../modelos/Permiso.php";
			$permiso = new Permiso();
			$rspta = $permiso->listar();
		
			// obtener permisos asignados
			$id = $_GET['id'];
			$marcados = $usuario->listarmarcados($id);
			$valores = array();
		
			// almacenar permisos asignados
			while ($per = $marcados->fetch_object()) {
				array_push($valores, $per->idPermiso);
			}
		
			// almacenar la lista de permisos en un array asociativo
			$listaPermisos = array();
			while ($reg = $rspta->fetch_object()) {
				$sw = in_array($reg->idPermiso, $valores) ? 'checked' : '';
				$listaPermisos[] = array(
					'idPermiso' => $reg->idPermiso,
					'nombre' => $reg->nombre,
					'checked' => $sw
				);
			}
		
			// devolver la lista de permisos como JSON
			echo json_encode($listaPermisos);
		
			break;

	case 'verificar':
		// Validar si el usuario tiene acceso al sistema
		$logina = $_POST['logina'];
		$clavea = $_POST['clavea'];

		//Hash SHA256 en la contraseña
		$clavehash = hash("SHA256", $clavea);

		$rspta = $usuario->verificar($logina, $clavehash);

		$fetch = $rspta->fetch_object();
		if (isset($fetch)) {
			# Declaramos la variables de sesion
			$_SESSION['idUsuario'] = $fetch->idUsuario;
			$_SESSION['login'] = $fetch->login;
			$nombreEmpleado = $usuario->obtenerNombreEmpleado($fetch->idUsuario);
			$_SESSION['nombreEmpleado'] = $nombreEmpleado;
			//obtenemos los permisos
			$marcados = $usuario->listarmarcados($fetch->idUsuario);

			//declaramos el array para almacenar todos los permisos
			$valores = array();

			//almacenamos los permisos marcados en al array
			while ($per = $marcados->fetch_object()) {
				array_push($valores, $per->idPermiso);
			}

			//determinamos lo accesos al usuario
			in_array(1, $valores) ? $_SESSION['Escritorio'] = 1 : $_SESSION['Escritorio'] = 0;
			in_array(2, $valores) ? $_SESSION['Almacen'] = 1 : $_SESSION['Almacen'] = 0;
			in_array(3, $valores) ? $_SESSION['Empleados'] = 1 : $_SESSION['Empleados'] = 0;
			in_array(4, $valores) ? $_SESSION['Acceso'] = 1 : $_SESSION['Acceso'] = 0;
			in_array(5, $valores) ? $_SESSION['Cotizaciones'] = 1 : $_SESSION['Cotizaciones'] = 0;
			in_array(6, $valores) ? $_SESSION['Terceros'] = 1 : $_SESSION['Terceros'] = 0;
			in_array(7, $valores) ? $_SESSION['OT'] = 1 : $_SESSION['OT'] = 0;
		}
		echo json_encode($fetch);


		break;
	case 'salir':
		//limpiamos la variables de la secion
		session_unset();

		//destruimos la sesion
		session_destroy();
		//redireccionamos al login
		header("Location: ../index.php");
		break;
}
