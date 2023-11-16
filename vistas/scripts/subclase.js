var tabla;

init();

//funcion que se ejecuta al inicio
function init(){
   listar();

   $.post("../controlador/subclase.php?op=selectClase", function(r){
    $("#idClase").html(r);
	$("#idClase").select2();
	$("#idClase").append('<option disabled selected value="">Selecciona o escriba una clase</option>');
	$("#idClase").select2('refresh');
});


$.post("../controlador/subclase.php?op=selectClase", function(r){
    $("#idClaseUpdate").html(r);
	$("#idClaseUpdate").select2();
	$("#idClaseUpdate").append('<option disabled selected value="">Selecciona o escriba una clase</option>');
	$("#idClaseUpdate").select2('refresh');
});
  
}

//funcion listar
function listar(){

	tabla=$('#tbllistado').dataTable({
		dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
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
            "lengthMenu": [10, 10, 20, 50],
            "pageLength": 10,
			
		"ajax":
		{
			url:'../controlador/subclase.php?op=listar',
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



function mostrar(idSubclase){

	$.ajax({
		data:{"idSubclase":idSubclase},
		url:'../controlador/subclase.php?op=mostrar',
		type:"post",
		beforeSend:function(){},
		success: function(response){
			console.log(response)
			data=$.parseJSON(response);
				$("#idSubclaseUpdate").val(data['idSubclase']);
				$("#idClaseUpdate").val(data['idClase']);
				$("#nombreUpdate").val(data['nombre']);	
		}
	})
}


function guardar(){
	nombre = $('#nombre').val();
	idClase = $('#idClase').val();
	parametros = {"nombre":nombre,"idClase":idClase}
	
	$.ajax({
		data: parametros,
		url: '../controlador/subclase.php?op=guardar',
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
}


function Actualizar(){
	idSubclase=$('#idSubclaseUpdate').val();
	idClase=$('#idClaseUpdate').val();
	nombre=$('#nombreUpdate').val();
	parametros ={"idSubclase":idSubclase,"idClase":idClase,"nombre":nombre}
	$.ajax({
		data: parametros,
		url: '../controlador/subclase.php?op=editar',
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
function confirmarEliminacion(idSubclase) {
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
				desactivar(idSubclase);
				tabla.ajax.reload();

			}else{
				swal("cancelado","el registro no fue eliminado","error");
			}
		});
	});
}


function desactivar(idSubclase) {
	$.ajax({
		data: { "idSubclase": idSubclase },
		url: '../controlador/subclase.php?op=desactivar',
		type: "POST",
		beforeSend: function () { }
		
	});
}

//funcion para desactivar
function confirmarActivacion(idSubclase) {

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
				activar(idSubclase);
				tabla.ajax.reload();

			}else{
				swal("cancelado","el registro no fue activado","error");
			}
		});
	});

}
function activar(idSubclase) {
	$.ajax({
		data: { "idSubclase": idSubclase },
		url: '../controlador/subclase.php?op=activar',
		type: "POST",
		beforeSend: function () { }
	});
}
