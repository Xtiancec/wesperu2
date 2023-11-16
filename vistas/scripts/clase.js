var tabla;

//funcion que se ejecuta al inicio
init();
function init(){
	listar();

}

function listar(){

	tabla=$('#tbllistado').dataTable({
		dom: '<"row"<"col-md-12"<"row"<"col-md-12"B><"col-md-12"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-12"i><"col-md-12"p>>> >',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'csv', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                    { extend: 'print', className: 'btn' }
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
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10,
			
		"ajax":
		{
			url:'../controlador/clase.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}
function mostrar(idClase){

	$.ajax({
		data:{"idClase":idClase},
		url:'../controlador/clase.php?op=mostrar',
		type:"post",
		beforeSend:function(){},
		success: function(response){
			console.log(response)
			data=$.parseJSON(response);
				$("#idClaseUpdate").val(data['idClase']);
				$("#nombreUpdate").val(data['nombre']);
			

		}
	})
}

function guardar(){
	nombre = $('#nombre').val();
	parametros = {"nombre":nombre}
	
	$.ajax({
		data: parametros,
		url: '../controlador/clase.php?op=guardar',
		type: "POST",
		beforeSend:function(){},
		success:function(response){
			if(response == "success"){
				console.log(response);
                tabla.ajax.reload();
				$("#formularioregistro").modal("hide");
				toastr.success("Se guardo correctamente los datos","Registro exitoso");

            } else if (response =="requerid") {
                toastr.error("Complete todos los requeridos porfavor","Campos incompletos!");
            } else {
                toastr.error("Comuniquese con su proveedor","Error!");
            }
		}
	})

	tabla.ajax.reload();		


/*
	$(document).ready(function(){
		$('#formularioregistros').click(function(){
			$('#formularioregistros').show();
		})
	});

	$(document).on('submit','#formulario',function(e){
		e.preventDefault();
		var nombre=$('#nombre').val();
		$.ajax({
			type:'POST',
			url: '../controlador/clase.php?op=guardar',
			data: {nombre:nombre},
			success: function(response){
				console.log(response);
				$('#formularioregistros').modal('hide');
				$('#nombre').val('');
				
			}
		});		
		$(document).on('click', '.close', function() {
       	 	$('#formularioregistros').hide();
    	});
		tabla.ajax.reload();		
})

*/
}

function Actualizar(){
	idClase=$('#idClaseUpdate').val();
	nombre=$('#nombreUpdate').val();
	parametros ={"idClase":idClase,"nombre":nombre}
	$.ajax({
		data: parametros,
		url: '../controlador/clase.php?op=editar',
		type: "POST",
		beforeSend: function(){},
		success:function(response){
	
			console.log(response);
			if(response=="success"){		
				tabla.ajax.reload();
				$("#formularioActualizar").modal("hide");
				
			} else if(response=="requerid"){
				toast.error("complete los datos por favor","Datos incompletos");

			}else{
				toast.error("Comuniquese con el administrador","ERROR");
			}
		}
	})
}

//funcion para desactivar
function confirmarEliminacion(idClase) {
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
				desactivar(idClase);
				tabla.ajax.reload();

			}else{
				swal("cancelado","el registro no fue eliminado","error");
			}
		});
	});
}


function desactivar(idClase) {
	$.ajax({
		data: { "idClase": idClase },
		url: '../controlador/clase.php?op=desactivar',
		type: "POST",
		beforeSend: function () { }
		
	});
}

//funcion para desactivar
function confirmarActivacion(idClase) {

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
				activar(idClase);
				tabla.ajax.reload();

			}else{
				swal("cancelado","el registro no fue activado","error");
			}
		});
	});

}
function activar(idClase) {
	$.ajax({
		data: { "idClase": idClase },
		url: '../controlador/clase.php?op=activar',
		type: "POST",
		beforeSend: function () { }
	});
}
