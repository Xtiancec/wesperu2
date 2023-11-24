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
    cargarSelect("../controlador/requerimiento.php?op=selectOT", "#idOT");
	cargarSelect("../controlador/requerimiento.php?op=selectTipoSalida", "#idTipoSalida");
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
			url: '../controlador/requerimiento.php?op=listarporautorizar',
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
			url: '../controlador/requerimiento.php?op=listarExistencias',
			type: "GET",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy":true

	});
}


$(document).ready(function () {
    // Asociar la función generarCorrelativo con el evento onchange
    $("#idTipoSalida").change(generarCorrelativo);
});

function generarCorrelativo() {
    // Obtener el valor seleccionado del tipo de salida
    var idTipoSalida = $("#idTipoSalida").val();

    // Hacer la solicitud AJAX para obtener la última secuencia
    $.ajax({
        url: "../controlador/Requerimiento.php?op=obtenerUltimaSecuenciaPorTipoSalida&idTipoSalida=" + idTipoSalida,
        type: "GET",
        dataType: "json",
        success: function (data) {
            // Verificar si la respuesta contiene datos
            if (data && data.letra !== undefined && data.ultimaSecuencia !== undefined) {
                // Generar el correlativo y asignarlo al campo
                var letraTipoSalida = data.letra;
                var ultimaSecuencia = data.ultimaSecuencia;
                var nuevaSecuencia = ultimaSecuencia + 1;
                var correlativoGenerado = letraTipoSalida + ("0000000" + nuevaSecuencia).slice(-7);

                // Asignar el valor al campo correlativo y desactivar el atributo readonly
                $("#correlativo").val(correlativoGenerado);
            } else {
                // Si la respuesta no contiene datos, mostrar un mensaje o manejar el error según sea necesario
                console.error("La respuesta AJAX no contiene datos válidos.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        }
    });
}
// Función para guardar y editar
function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#formulario")[0]);


	$.ajax({
		url: "../controlador/requerimiento.php?op=guardaryeditar",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		success: function (datos) {
			console.log(datos);
			mostrarform(false);
			listar();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
		}
	});

    limpiar();
}

function mostrar(idRequerimiento) {
    $.post("../controlador/requerimiento.php?op=mostrar", { idRequerimiento: idRequerimiento },
        function (data, status) {
            data = JSON.parse(data);
			console.log(data);
            mostrarform(true);
            // Establecer y activar select2
            $("#numero").val(data.numero).select2();
			$("#idOT").val(data.idOT).select2();
			$("#correlativo").val(data.correlativo).select2();
            $("#fecha").val(data.fecha);
            $("#estado").val(data.estado);
            // Ocultar el botón de guardar y mostrar el de cancelar
            $("#btnGuardar").hide();
            $("#btnCancelar").show();
            $("#btnAgregarArt").hide();
            // Destruir e inicializar Select2 después de cargar el contenido
            reinicializarSelect2();
        });

    $.ajax({
        url: "../controlador/requerimiento.php?op=listarDetalle&id=" + idRequerimiento,
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
    $("#idOT, #idTipoSalida").select2('destroy').select2();
}

var cont = 0;
var detalles = 0;

$("#btnGuardar").hide();



var cont = 1; // Contador global para filas
var detalles = 0; // Contador de detalles
function agregarDetalle(idExistencia, existencia) {
    // Verificar si ya existe una fila con el mismo idExistencia
    var filaExistente = $('#detalles').find('input[name="idExistencia[]"][value="' + idExistencia + '"]').closest('tr');

    if (filaExistente.length > 0) {
        // Si ya existe la fila, aumenta la cantidad en uno
        var cantidadInput = filaExistente.find('input[name="stockSolicitado[]"]');
        var cantidadActual = parseInt(cantidadInput.val());
        cantidadInput.val(cantidadActual + 1);
    } else {
        // Si no existe la fila, crea una nueva fila
        var stockSolicitado = 1;

        var fila = '<tr class="filas" id="fila' + cont + '">' +
            '<td class="text-center">' + cont + '</td>' +
            '<td class="text-center"><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button></td>' +
            '<td><input type="hidden" name="idExistencia[]" value="' + idExistencia + '">' + existencia + '</td>' +
            '<td><input class="text-right" type="number" name="stockSolicitado[]" max="1000" value="' + stockSolicitado + '"></td>' +
            '</tr>';

        cont++;
        detalles++;
        $('#detalles').append(fila);
        evaluar();
    }
}

function formatearConComa(numero) {
    return numero.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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

