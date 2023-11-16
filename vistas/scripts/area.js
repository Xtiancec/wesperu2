var tabla;
Init();
//funcion que se ejecuta al inicio
function Init() {
	listar();
}


//funcion listar
function listar() {

	tabla = $('#tbllistado').DataTable({
		"ajax":
		{
			url: '../controlador/area.php?op=listar',
			type: "get",
			dataType: "json",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
		buttons: {
			buttons: [
				{ extend: 'copy', className: 'btn' },
				{ extend: 'csv', className: 'btn' },
				{ extend: 'excel', className: 'btn' },
				{ extend: 'print', className: 'btn' },
				{ extend: 'pageLength', className: 'btn' }
			]
		},
		"order": [[0, "desc"]],//ordenar (columna, orden)
		"oLanguage": {
			"oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
			"sInfo": "Mostrando paginas _PAGE_ of _PAGES_",
			"sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
			"sSearchPlaceholder": "Buscar...",
			"sLengthMenu": "Resultados :  _MENU_",
		},

		"stripeClasses": [],
		"lengthMenu": [10, 25, 50, 100, 200],
		"pageLength": 10



	});
}


function mostrar(idArea) {

	$.ajax({
		data: { "idArea": idArea },
		url: '../controlador/area.php?op=mostrar',
		type: "post",
		beforeSend: function () { },
		success: function (response) {
			console.log(response)
			data = $.parseJSON(response);
			$("#idAreaUpdate").val(data['idArea']);
			$("#nombreUpdate").val(data['nombre']);


		}
	})
}

function guardar() {
	nombre = $('#nombre').val();
	parametros = { "nombre": nombre }

	$.ajax({
		data: parametros,
		url: '../controlador/area.php?op=guardar',
		type: "POST",
		beforeSend: function () { },
		success: function (response) {
			if (response == "success") {
				console.log(response);
				tabla.ajax.reload();
				$("#formularioregistro").modal("hide");
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

function Actualizar() {
	idArea = $('#idAreaUpdate').val();
	nombre = $('#nombreUpdate').val();
	parametros = { "idArea": idArea, "nombre": nombre }
	$.ajax({
		data: parametros,
		url: '../controlador/area.php?op=editar',
		type: "POST",
		beforeSend: function () { },
		success: function (response) {

			console.log(response);
			if (response == "success") {
				tabla.ajax.reload();
				$("#formularioActualizar").modal("hide");

			} else if (response == "requerid") {
				toast.error("complete los datos por favor", "Datos incompletos");

			} else {
				toast.error("Comuniquese con el administrador", "ERROR");
			}
		}
	})
}



//funcion para desactivar
function confirmarEliminacion(idArea) {
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
				desactivar(idArea);
				tabla.ajax.reload();

			}else{
				swal("cancelado","el registro no fue eliminado","error");
			}
		});
	});
}


function desactivar(idArea) {
	$.ajax({
		data: { "idArea": idArea },
		url: '../controlador/area.php?op=desactivar',
		type: "POST",
		beforeSend: function () { }
		
	});
}

//funcion para desactivar
function confirmarActivacion(idArea) {

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
				activar(idArea);
				tabla.ajax.reload();

			}else{
				swal("cancelado","el registro no fue activado","error");
			}
		});
	});

}
function activar(idArea) {
	$.ajax({
		data: { "idArea": idArea },
		url: '../controlador/area.php?op=activar',
		type: "POST",
		beforeSend: function () { }
	});
}


