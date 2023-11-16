var tabla;

init();

//funcion que se ejecuta al inicio
function init(){
   listar();

   $.post("../controlador/ot.php?op=selectAlmacen", function(r){
    $("#idAlmacen").html(r);
	$("#idAlmacen").select2();
	$("#idAlmacen").append('<option disabled selected value="">Selecciona o escriba un almacen</option>');
	$("#idAlmacen").select2('refresh');
});


$.post("../controlador/ot.php?op=selectEmpresa", function(r){
    $("#idEmpresa").html(r);
	$("#idEmpresa").select2();
	$("#idEmpresa").append('<option disabled selected value="">Selecciona o escriba una empresa</option>');
	$("#idEmpresa").select2('refresh');
});


  
}

jQuery('#date-range').datepicker({
	toggleActive: true
});

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
			url:'../controlador/ot.php?op=listar',
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



function mostrar(idOT){

	$.ajax({
		data:{"idOT":idOT},
		url:'../controlador/ot.php?op=mostrar',
		type:"post",
		beforeSend:function(){},
		success: function(response){
			console.log(response)
			data=$.parseJSON(response);
				$("#idOTUpdate").val(data['idOT']);
				$("#idEmpresaUpdate").val(data['idEmpresa']);
				$("#idAlmacenUpdate").val(data['idAlmacen']);	
                $("#numeroUpdate").val(data['numero']);	
				$("#descripcionUpdate").val(data['descripcion']);	
				$("#fechaInicioUpdate").val(data['fechaInicio']);	
				$("#fechaFinUpdate").val(data['fechaFin']);	
				$("#estadoUpdate").val(data['estado']);	

            }
	})
}


function guardar(){
	idEmpresa = $('#idEmpresa').val();
	idAlmacen = $('#idAlmacen').val();
	numero = $('#numero').val();
	descripcion = $('#descripcion').val();
	fechaInicio = $('#fechaInicio').val();
	fechaFin = $('#fechaFin').val();
    estado = $('#estado').val();

    parametros = {"idEmpresa":idEmpresa,
    "idAlmacen":idAlmacen,
    "numero":numero,
    "descripcion":descripcion,
    "fechaInicio":fechaInicio,
    "fechaFin":fechaFin,
    "estado":estado
}
	
	$.ajax({
		data: parametros,
		url: '../controlador/ot.php?op=guardar',
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
    idOT=$('#idOTUpdate').val();
	idAlmacen = $('#idAlmacenUpdate').val();
	numero = $('#numeroUpdate').val();
	descripcion = $('#descripcionUpdate').val();
	fechaInicio = $('#fechaInicioUpdate').val();
	fechaFin = $('#fechaFinUpdate').val();
    estado = $('#estadoUpdate').val();

    parametros = {
    "idOT":idOT,
    "idEmpresa":idEmpresa,
    "idAlmacen":idAlmacen,
    "numero":numero,
    "descripcion":descripcion,
    "fechaInicio":fechaInicio,
    "fechaFin":fechaFin,
    "estado":estado}
    $.ajax({
		data: parametros,
		url: '../controlador/ot.php?op=editar',
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
	});

}





function limpiar(){
	$("#idSubclase").val("");
	$("#nombre").val("");
	$("#idClase").val("");
	$("#idSubclaseUpdate").val("");
	$("#nombreUpdate").val("");
	$("#idClaseUpdate").val("");
}


function limitarLongitud(input, maxLength) {
	if (input.value.length > maxLength) {
	  input.value = input.value.slice(0, maxLength); // Truncar el valor a la longitud máxima
	}
  }

//cancelar form
function cancelarform(){
	limpiar();
	mostrarform(false);
}

