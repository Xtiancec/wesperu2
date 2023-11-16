<?php
require_once "../modelos/Comprobante.php";
$comprobante = new Comprobante();
$idComprobante = isset($_POST["idComprobante"]) ? limpiarCadena($_POST["idComprobante"]) : "";
$idEmpresa = isset($_POST["idEmpresa"]) ? limpiarCadena($_POST["idEmpresa"]) : "";
$idTipocomprobante = isset($_POST["idTipocomprobante"]) ? limpiarCadena($_POST["idTipocomprobante"]) : "";
$idTipoingreso = isset($_POST["idTipoingreso"]) ? limpiarCadena($_POST["idTipoingreso"]) : "";
$idAlmacen = isset($_POST["idAlmacen"]) ? limpiarCadena($_POST["idAlmacen"]) : "";
$numero = isset($_POST["numero"]) ? limpiarCadena($_POST["numero"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";
$precioTotal = isset($_POST["precioTotal"]) ? limpiarCadena($_POST["precioTotal"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idComprobante)) {
			$rspta = $comprobante->insertar(
				$idTipocomprobante,
				$idEmpresa,
				$idTipoingreso,
				$idAlmacen,
				$numero,
				$fecha,
				$precioTotal,
				$_POST["idExistencia"],
				$_POST["cantidad"],
				$_POST["precio"]
			);
			echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
		} else {
			$rspta = $comprobante->editar(
				$idComprobante,
				$idTipocomprobante,
				$idEmpresa,
				$idTipoingreso,
				$idAlmacen,
				$numero,
				$fecha,
				$precioTotal,
				$_POST["idExistencia"],
				$_POST["cantidad"],
				$_POST["precio"]
			);
			echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
		}
		break;


	case 'anular':
		$rspta = $comprobante->anular($idComprobante);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
		break;

	case 'mostrar':
		$rspta = $comprobante->mostrar($idComprobante);
		echo json_encode($rspta);
		break;


	case 'listarDetalle':
		$id = $_GET['id'];

		$rspta = $comprobante->listarDetalle($id);
		$total = 0;
		$item = 0; // Nuevo contador para el número de ítem

		echo '<thead style="background-color: #191970; color: white;">
					<th class="text-center"><b>N°</b></th>
					<th class="text-center"><b>Existencia</b></th>
					<th class="text-center"><b>Cantidad</b></th>
					<th class="text-center"><b>U.M.</b></th>
					<th class="text-center"><b>Precio</b></th>
					<th class="text-center"><b>Sub Total</b></th>
					<th></th>
				  </thead>';

		while ($reg = $rspta->fetch_object()) {
			$item++; // Incrementar el contador de ítems en cada iteración
			$precioRedondeado = number_format($reg->precio, 2);
			$subtotal = number_format($reg->cantidad * $reg->precio, 2);
			$total += $subtotal;

			echo '<tr class="filas">
						<td class="text-center">' . $item . '</td>
						<td>' . $reg->existencia . '</td>
						<td class="text-right">' . $reg->cantidad . '</td>
						<td>' . $reg->um . '</td>
						<td class="text-right">S/. ' . $precioRedondeado . '</td>
						<td class="text-right"><b>S/. ' . $subtotal . '</b></td>
					  </tr>';
		}

		echo '<tfoot>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th><b>TOTAL:</b></th>
					<th class="text-right"><h4 id="total">S/. ' . number_format($total, 2) . '</h4><input type="hidden" name="precioTotal" id="precioTotal"></th>
				  </tfoot>';
		break;




	case 'listar':
		$rspta = $comprobante->listar();
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(

				"0" => $reg->fecha,
				"1" => $reg->empresa,
				"2" => $reg->tipoComprobante,
				"3" => $reg->almacen,
				"4" => $reg->tipoIngreso,
				"5" => $reg->precioTotal,
				"6" => $reg->numero,
				"7" => ($reg->estado == 'Aceptado') ? '<span class="badge badge-success">Aceptado</span>' : '<span class="badge badge-danger">Anulado</span>',
				"8" => ($reg->estado == 'Aceptado') ?
					'<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idComprobante . ')"><i class="fa fa-eye"></i></button>' . ' ' .
					'<button class="btn btn-danger btn-xs" onclick="anular(' . $reg->idComprobante . ')"><i class="fa fa-close"></i></button>' :
					'<button class="btn btn-warning btn-xs" onclick="mostrar(' . $reg->idComprobante . ')"><i class="fa fa-eye"></i></button>',

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








	case 'selectProveedor':

		require_once "../modelos/Empresa.php";
		$empresa = new Empresa();

		$rspta = $empresa->listarProveedores();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idEmpresa . '>' . $reg->nombre . '</option>';
		}
		break;



	case 'selectTipoIngreso':
		require_once "../modelos/TipoIngreso.php";
		$tipoingreso = new TipoIngreso();

		$rspta = $tipoingreso->select();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idTipoingreso . '>' . $reg->nombre . '</option>';
		}
		break;



	case 'selectAlmacen':
		require_once "../modelos/Almacen.php";
		$almacen = new Almacen();
		$rspta = $almacen->select();
		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idAlmacen . '>' . $reg->nombre . '</option>';
		}
		break;

	case 'selectTipoComprobante':

		require_once "../modelos/TipoComprobante.php";
		$tipocomprobante = new TipoComprobante();
		$rspta = $tipocomprobante->select();

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idTipocomprobante . '>' . $reg->nombre . '</option>';
		}
		break;
}
