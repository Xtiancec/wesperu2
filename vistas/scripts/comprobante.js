var tabla;

init();
// Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });

    // Cargamos los items al select cliente
    cargarSelect("../controlador/comprobante.php?op=selectProveedor", "#idEmpresa");
    cargarSelect("../controlador/comprobante.php?op=selectAlmacen", "#idAlmacen");
    cargarSelect("../controlador/comprobante.php?op=selectTipoIngreso", "#idTipoingreso");
    cargarSelect("../controlador/comprobante.php?op=selectTipoComprobante", "#idTipocomprobante");
}

function cargarSelect(url, idSelect) {
    $.post(url, function (r) {
        $(idSelect).html(r);
        $(idSelect).append('<option disabled selected value="">Seleccione una opción</option>');
        $(idSelect).select2(); // Inicializa Select2 después de cargar el contenido
    });
}
// Función limpiar
function limpiar() {
	$("#numero").val("");
	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");

	// Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear() + "-" + (month) + "-" + (day);
	$("#fecha").val(today);
}

// Función mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();
		listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles = 0;
		$("#btnAgregarArt").show();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

// Cancelar form
function cancelarform() {
	limpiar();
	mostrarform(false);
}

// Función listar
function listar() {
	tabla = $('#tbllistado').DataTable({
		"aProcessing": true,
		"aServerSide": true,
		dom: 'Bfrtip',
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdf'
		],
		"ajax": {
			url: '../controlador/comprobante.php?op=listar',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 10,
		"order": [[0, "desc"]]
	});
}

function listarArticulos() {
	tabla = $('#tblexistencias').DataTable({

		"order": [3, "asc"],
		"displayLength": 10,
		dom: 'lBfrtip',//definimos los elementos del control de la tabla
		buttons: [

		],
		"ajax": {
			url: '../controlador/comprobante.php?op=listarExistencias',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy":true

	});
}

// Función para guardar y editar
function guardaryeditar(e) {
	e.preventDefault();
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controlador/comprobante.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			mostrarform(false);
			listar();
		}
	});

	limpiar();
}


function mostrar(idComprobante) {
    $.post("../controlador/comprobante.php?op=mostrar", { idComprobante: idComprobante },
        function (data, status) {
            data = JSON.parse(data);
			console.log(data);
            mostrarform(true);

            // Establecer y activar select2
            $("#idTipoingreso").val(data.idTipoingreso).select2();
            $("#idEmpresa").val(data.idEmpresa).select2();
            $("#idAlmacen").val(data.idAlmacen).select2();
			$("#idTipocomprobante").val(data.idTipocomprobante).select2();
            $("#fecha").val(data.fecha);
            $("#numero").val(data.numero);
            $("#precioTotal").val(data.precioTotal);

            // Ocultar el botón de guardar y mostrar el de cancelar
            $("#btnGuardar").hide();
            $("#btnCancelar").show();
            $("#btnAgregarArt").hide();

            // Destruir e inicializar Select2 después de cargar el contenido
            reinicializarSelect2();
        });

    $.ajax({
        url: "../controlador/comprobante.php?op=listarDetalle&id=" + idComprobante,
        type: "GET",
        dataType: "html",
        success: function (r) {
            $("#detalles").html(r);

            // Destruir e inicializar Select2 después de cargar el contenido
            reinicializarSelect2();
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });
}

function reinicializarSelect2() {
    $("#idTipocomprobante, #idTipoingreso, #idEmpresa, #idAlmacen").select2('destroy').select2();
}

var cont = 0;
var detalles = 0;

$("#btnGuardar").hide();



var cont = 1; // Contador global para filas
var detalles = 0; // Contador de detalles

function agregarDetalle(idExistencia, existencia) {
    var precio = 1;

    // Verificar si ya existe una fila con el mismo idExistencia
    var filaExistente = $('#detalles').find('input[name="idExistencia[]"][value="' + idExistencia + '"]').closest('tr');

    if (filaExistente.length > 0) {
        // Si ya existe la fila, aumenta la cantidad en uno
        var cantidadInput = filaExistente.find('input[name="cantidad[]"]');
        var cantidadActual = parseInt(cantidadInput.val());
        cantidadInput.val(cantidadActual + 1);

        // Actualizar subtotal
        var subtotalSpan = filaExistente.find('[name="subtotal"]');
        var nuevoSubtotal = parseFloat(cantidadInput.val()) * parseFloat(filaExistente.find('input[name="precio[]"]').val());
        subtotalSpan.text(nuevoSubtotal.toFixed(2));
    } else {
        // Si no existe la fila, crea una nueva fila
        var cantidad = 1;
        var subtotal = cantidad * precio;

        var fila = '<tr class="filas" id="fila' + cont + '">' +
            '<td class="text-center">' + cont + '</td>' + // Número de ítem
            '<td class="text-center"><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button></td>' +
            '<td><input type="hidden" name="idExistencia[]" value="' + idExistencia + '">' + existencia + '</td>' +
            '<td><input class="text-right" type="number" name="cantidad[]" max="1000" id="cantidad[]" value="' + cantidad + '"></td>' +
            '<td><input class="text-right" type="number" step="0.01" name="precio[]" id="precio[]" value="' + precio + '"></td>' +
            '<td class="text-right"><b><span id="subtotal' + cont + '" name="subtotal">' + subtotal + '</span></b></td>' +
            '<td class="text-center"><button type="button" onclick="modificarSubtotales()" class="btn btn-info"><i class="fa fa-spin fa-refresh"></i></button></td>' +
            '</tr>';

        cont++;
        detalles++;

        $('#detalles').append(fila);
        modificarSubtotales();
    }
}


function formatearConComa(numero) {
    return numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


function modificarSubtotales() {
	var cant = document.getElementsByName("cantidad[]");
	var prev = document.getElementsByName("precio[]");
	var sub = document.getElementsByName("subtotal");

	for (var i = 0; i < cant.length; i++) {
		var inpV = cant[i];
		var inpP = prev[i];
		var inpS = sub[i];

		inpS.value = inpV.value * inpP.value;
		document.getElementsByName("subtotal")[i].innerHTML = formatearConComa("S/." +inpS.value.toFixed(2));
		
	}
	calcularTotales();
}


function calcularTotales() {
	var sub = document.getElementsByName("subtotal");
	var total = 0.0;

	for (var i = 0; i < sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html(formatearConComa("S/." + total.toFixed(2)));
	$("#precioTotal").val(total);
	evaluar();
}

function evaluar() {
	if (detalles > 0) {
		$("#btnGuardar").show();
	} else {
		$("#btnGuardar").hide();
		cont = 0;
	}
}

function eliminarDetalle(indice) {
	$("#fila" + indice).remove();
	calcularTotales();
	detalles = detalles - 1;
}

