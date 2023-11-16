var tabla;
init();
//funcion que se ejecuta al inicio
function init() {
	listar();
	listarClientes();
	listarProveedores();
    $.post("../controlador/empresa.php?op=selectBanco", function (r) {
        $("#idBanco").html(r);
        $("#idBanco").select2();
        $("#idBanco").append('<option disabled selected value="">seleccione un banco</option>');
        $("#idBanco").select2('refresh');
    });
}


//funcion listar
function listar() {

	tabla = $('#tbllistado').dataTable({
		dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
		buttons: {
			buttons: [
				{ extend: 'copy', className: 'btn' },
				{ extend: 'csv', className: 'btn' },
				{ extend: 'excel', className: 'btn' },
				{ extend: 'print', className: 'btn' },
				{ extend: 'pageLength', className: 'btn' },
			]
		},
		"oLanguage": {
			"oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
			"sInfo": "Mostrando página _PAGE_ de _PAGES_",
			"sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
			"sSearchPlaceholder": "Buscar...",
			"sLengthMenu": "Results :  _MENU_",
		},
		"stripeClasses": [],
		"lengthMenu": [10, 10, 20, 50],
		"pageLength": 10,

		"ajax":
		{
			url: '../controlador/empresa.php?op=listar',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseHtml);
			}
		},
		"bDestroy": true,

		"order": [[0, "desc"]]//ordenar (columna, orden)
	}).DataTable();
}

/*
$(document).ready(function(){
	$('#RUC').on("input", function() {
		var ruc = $(this).val();
		if (ruc.length !== 11) {
			return;
		}

		$.ajax({
			url: "api.php",
			data: 'ruc=' + ruc,
			dataType: "json",
			success: function(data) {
				console.log(data);
				$("#nombre").val(data.nombre);
				$("#numeroDocumento").val(data.numeroDocumento);
				$("#direccion").val(data.direccion);
				$("#estados").val(data.estado);
				$("#condicion").val(data.condicion);
				$("#departamento").val(data.departamento);
				$("#provincia").val(data.provincia);
				$("#distrito").val(data.distrito);
			},
			error: function() {
				console.error("error al realizar solicitud");
			}
		});

	})
})
*/
function guardar() {
	let idBanco = $('#idBanco').val();
	let tipoEmpresa = $('#tipoEmpresa').val();
	let nombre = $('#nombre').val();
	let RUC = $('#RUC').val();
	let numeroDocumento = $('#numeroDocumento').val();		
	let direccion = $('#direccion').val(	);
	let estados = $('#estados').val();
	let condicion = $('#condicion').val();
	let departamento = $('#departamento').val();
	let provincia = $('#provincia').val();
	let distrito = $('#distrito').val();
	let telefono = $('#telefono').val();
	let numeroCuenta = $('#numeroCuenta').val();
	let informacionGeneral = $('#informacionGeneral').val();

	console.log(RUC);
	parametros = { 
		"idBanco": idBanco, 
		"tipoEmpresa": tipoEmpresa, 
		"nombre": nombre, 
		"RUC": RUC,
		"numeroDocumento": numeroDocumento,
		"direccion": direccion,
		"estados": estados,
		"condicion": condicion,
		"departamento": departamento,
		"provincia": provincia,
		"distrito": distrito,		
		"telefono": telefono, 
		"numeroCuenta": numeroCuenta, 
		"informacionGeneral": informacionGeneral }
		console.log(parametros);

	$.ajax({
		data: parametros,
		url: '../controlador/empresa.php?op=guardar',
		type: "POST",
		beforeSend: function () { },
		success: function (response) {
			if (response == "success") {
				
				console.log(response);
				tabla.ajax.reload();
				$("#formularioregistros").modal("hide");
				toastr.success("Se guardo correctamente los datos", "Registro exitoso");

			} else if (response == "requerid") {
				toastr.error("Complete todos los requeridos porfavor", "Campos incompletos!");
			} else {
				toastr.error("Comuniquese con su proveedor", "Error!");
			}
		}
	})
	tabla.ajax.reload();
}

//funcion para desactivar
function confirmarEliminacion(idEmpresa) {

	$('.widget-content .warning.cancel').on('click', function () {
		const swalWithBootstrapButtons = swal.mixin({
			confirmButtonClass: 'btn btn-success btn-rounded',
			cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
			buttonsStyling: false,
		})

		swalWithBootstrapButtons({
			title: 'Esta seguro de eliminar el registro?',
			text: "Este registro se dara de baja hasta que se vuelva activar!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'si, Eliminalo!',
			cancelButtonText: 'No, cancelar!',
			reverseButtons: true,
			padding: '2em'
		}).then(function (result) {
			if (result.value) {
				desactivar(idEmpresa);
				swalWithBootstrapButtons(
					'Eliminado!',
					'El registro se dio de baja',
					'success'
				)
			} else if (
				// Read more about handling dismissals
				result.dismiss === swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons(
					'Cancelado',
					'El registro no fue eliminado :)',
					'error'
				)
			}
		})
	})


}


function desactivar(idEmpresa) {
	$.ajax({
		data: { "idEmpresa": idEmpresa },
		url: '../controlador/empresa.php?op=desactivar',
		type: "POST",
		beforeSend: function () { }
	});
	tabla.ajax.reload();
}

//funcion para desactivar
function confirmarAcivacion(idEmpresa) {

	$('.widget-content .warning.cancel').on('click', function () {
		const swalWithBootstrapButtons = swal.mixin({
			confirmButtonClass: 'btn btn-success btn-rounded',
			cancelButtonClass: 'btn btn-danger btn-rounded mr-3',
			buttonsStyling: false,
		})

		swalWithBootstrapButtons({
			title: 'Esta seguro de dar de alta el registro?',
			text: "Este registro será activado!",
			type: 'question',
			showCancelButton: true,
			confirmButtonText: 'si, Activalo!',
			cancelButtonText: 'No, cancelar!',
			reverseButtons: true,
			padding: '2em'
		}).then(function (result) {
			if (result.value) {
				activar(idEmpresa);
				swalWithBootstrapButtons(
					'Activado!',
					'El registro se ha dado de alta',
					'success'
				)
			} else if (
				// Read more about handling dismissals
				result.dismiss === swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons(
					'Cancelado',
					'El registro no fue dado de alta :)',
					'error'
				)
			}
		})
	})


}
function activar(idEmpresa) {
	$.ajax({
		data: { "idEmpresa": idEmpresa },
		url: '../controlador/empresa.php?op=activar',
		type: "POST",
		beforeSend: function () { }
	});
	tabla.ajax.reload();
}







function listarClientes() {

	tabla = $('#tbllistadoClientes').dataTable({
		dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
		buttons: {
			buttons: [
				{ extend: 'copy', className: 'btn' },
				{ extend: 'csv', className: 'btn' },
				{ extend: 'excel', className: 'btn' },
				{ extend: 'print', className: 'btn' },
				{ extend: 'pageLength', className: 'btn' },
			]
		},
		"oLanguage": {
			"oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
			"sInfo": "Mostrando página _PAGE_ de _PAGES_",
			"sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
			"sSearchPlaceholder": "Buscar...",
			"sLengthMenu": "Results :  _MENU_",
		},
		"stripeClasses": [],
		"lengthMenu": [10, 10, 20, 50],
		"pageLength": 10,

		"ajax":
		{
			url: '../controlador/empresa.php?op=listarClientes',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseHtml);
			}
		},
		"bDestroy": true,

		"order": [[0, "desc"]]//ordenar (columna, orden)
	}).DataTable();
}

function listarProveedores() {

	tabla = $('#tbllistadoProveedores').dataTable({
		dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
		buttons: {
			buttons: [
				{ extend: 'copy', className: 'btn' },
				{ extend: 'csv', className: 'btn' },
				{ extend: 'excel', className: 'btn' },
				{ extend: 'print', className: 'btn' },
				{ extend: 'pageLength', className: 'btn' },
			]
		},
		"oLanguage": {
			"oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
			"sInfo": "Mostrando página _PAGE_ de _PAGES_",
			"sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
			"sSearchPlaceholder": "Buscar...",
			"sLengthMenu": "Results :  _MENU_",
		},
		"stripeClasses": [],
		"lengthMenu": [10, 10, 20, 50],
		"pageLength": 10,

		"ajax":
		{
			url: '../controlador/empresa.php?op=listarProveedores',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseHtml);
			}
		},
		"bDestroy": true,

		"order": [[0, "desc"]]//ordenar (columna, orden)
	}).DataTable();
}



//funcion para desactivar
function confirmarEliminacion(idEmpresa) {
	$('#desactivar').click(function(){
		swal({
			title: 'Esta seguro de eliminar el registro?',
			text: "Este registro se dara de baja hasta que se vuelva activar!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor:"#DD6B55", 
			confirmButtonText: 'si, Eliminalo!',
			cancelButtonText: 'No, cancelar!',
			closeOnConfirm:false,
			closeOnCancel:false

		},function(isConfirm) {
			if(isConfirm){
				swal("Eliminado","el registro fue eliminado","success");
				desactivar(idExistencia);
				tabla.ajax.reload();

			}else{
				swal("cancelado","el registro no fue eliminado","error");
			}
		});
	});
}


function desactivar(idEmpresa) {
	$.ajax({
		data: { "idEmpresa": idEmpresa },
		url: '../controlador/empresa.php?op=desactivar',
		type: "POST",
		beforeSend: function () { }
		
	});
}

//funcion para desactivar
function confirmarActivacion(idEmpresa) {

	$('#activar').click(function(){
		swal({
			title: 'Esta seguro de activar el registro?',
			text: "Este registro se activará",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor:"#002A52E", 
			confirmButtonText: 'si, Activalo!',
			cancelButtonText: 'No, cancelar!',
			closeOnConfirm:false,
			closeOnCancel:false

		},function(isConfirm) {
			if(isConfirm){
				swal("Activado","el registro fue activado","success");
				activar(idEmpresa);
				tabla.ajax.reload();

			}else{
				swal("cancelado","el registro no fue activado","error");
			}
		});
	});

}
function activar(idEmpresa) {
	$.ajax({
		data: { "idEmpresa": idEmpresa },
		url: '../controlador/empresa.php?op=activar',
		type: "POST",
		beforeSend: function () { }
	});
}
