var tabla;
init();

function init() {
    listar();
    $.post("../controlador/usuario.php?op=permisos&id=", function (r) {
        try {
            // Parsea la respuesta JSON
            var listaPermisos = JSON.parse(r);

            // Limpia el contenido anterior
            $("#permisos").empty();

            // Itera sobre la lista de permisos y agrega cada uno al HTML
            $.each(listaPermisos, function (index, permiso) {
                var listItem = '<li class="permiso-item"><label>' + permiso.nombre + '</label><input type="checkbox" ' + permiso.checked + ' name="permiso[]" value="' + permiso.idPermiso + '"></li>';
                $("#permisos").append(listItem);
            });

            // Inicializa los interruptores Bootstrap Switch después de agregar los elementos
            $('[name="permiso[]"]').bootstrapSwitch();
        } catch (error) {
            console.error("Error al analizar como JSON:", error);
        }
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
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10,
			
		"ajax":
		{
			url:'../controlador/usuario.php?op=listar',
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

//funcion limpiar
function limpiar(){
	$("#login").val("");
	$("#clave").val("");
	$("#idusuario").val("");
}

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//cancelar form
function cancelarform(){
	limpiar();
	mostrarform(false);
}



//funcion para guardaryeditar
function guardaryeditar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controlador/usuario.php?op=guardar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });

    limpiar();
}

function mostrar(idUsuario){
	$.post("../controlador/usuario.php?op=mostrar",{idUsuario : idUsuario},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			
            $("#login").val(data.login);
            $("#clave").val(data.clave);
            $("#idUsuario").val(data.idUsuario);


		});
	$.post("../controlador/usuario.php?op=permisos&id="+idUsuario, function(r){
	$("#permisos").html(r);
});
}


//funcion para desactivar
function desactivar(idUsuario){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../controlador/usuario.php?op=desactivar", {idUsuario : idUsuario}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(idUsuario){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../controlador/usuario.php?op=activar", {idUsuario : idUsuario}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}


