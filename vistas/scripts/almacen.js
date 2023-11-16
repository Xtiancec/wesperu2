
var tabla;

//funcion que se ejecuta al inicio

init();
function init(){
   listar();
}

//funcion listar
function listar(){

	tabla=$('#tbllistado').DataTable({
		dom: 'Bfrtip',
		buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],


           
		"ajax":
		{
			url:'../controlador/almacen.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"lengthMenu": [10, 25, 50, 100], // Opciones para mostrar entradas
        "pageLength": 10,
		
		"order":[[0,"desc"]]//ordenar (columna, orden)
	});
}


function mostrar(idAlmacen){

	$.ajax({
		data:{"idAlmacen":idAlmacen},
		url:'../controlador/almacen.php?op=mostrar',
		type:"post",
		beforeSend:function(){},
		success: function(response){
			console.log(response)
			data=$.parseJSON(response);
				$("#idAlmacenUpdate").val(data['idAlmacen']);
				$("#nombreUpdate").val(data['nombre']);
				$("#direccionUpdate").val(data['direccion']);		
		}
	})
}


function guardar() {
    var nombre = $('#nombre').val();
    var direccion = $('#direccion').val();
    var parametros = {"nombre": nombre, "direccion": direccion};

    $.ajax({
        data: parametros,
        url: '../controlador/almacen.php?op=guardar',
        type: "POST",
        beforeSend: function () {},
        success: function (response) {
            if (response === "success") {
                console.log(response);
                $.toast({
                    heading: 'Almacen Guardado',
                    text: 'El registro se guardó correctamente',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'info',
                    hideAfter: 3000,
                    stack: 6
                });

                tabla.ajax.reload();
                $("#formularioregistro").modal("hide");

            } else if (response === "requerid") {
                $.toast({
                    heading: 'ERROR',
                    text: 'Complete todos los campos requeridos por favor',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'info',
                    hideAfter: 3000,
                    stack: 6
                });
            } else {
                $.toast({
                    heading: 'ERROR',
                    text: 'Comuníquese con su proveedor',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'info',
                    hideAfter: 3000,
                    stack: 6
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud Ajax:", status, error);
        }
    });
}



function Actualizar(){
	idAlmacen=$('#idAlmacenUpdate').val();
	nombre=$('#nombreUpdate').val();
	direccion=$('#direccionUpdate').val();
	parametros ={"idAlmacen":idAlmacen,"nombre":nombre,"direccion":direccion}
	$.ajax({
		data: parametros,
		url: '../controlador/almacen.php?op=editar',
		type: "POST",
		beforeSend: function(){},
		success:function(response){
			if(response==="success"){		
				tabla.ajax.reload();
				$("#formularioActualizar").modal("hide");
				
			} else if(response==="requerid"){
				toast.error("complete los datos por favor","Datos incompletos");

			}else{
				toast.error("Comuniquese con el administrador","ERROR");
			}
		}
	})
}


//funcion para desactivar
function confirmarEliminacion(idAlmacen) {
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
				desactivar(idAlmacen);
				tabla.ajax.reload();

			}else{
				swal("cancelado","el registro no fue eliminado","error");
			}
		});
	});
}


function desactivar(idAlmacen) {
	$.ajax({
		data: { "idAlmacen": idAlmacen },
		url: '../controlador/almacen.php?op=desactivar',
		type: "POST",
		beforeSend: function () { }
		
	});
}

//funcion para desactivar
function confirmarActivacion(idAlmacen) {

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
				activar(idAlmacen);
				tabla.ajax.reload();

			}else{
				swal("cancelado","el registro no fue activado","error");
			}
		});
	});

}
function activar(idAlmacen) {
	$.ajax({
		data: { "idAlmacen": idAlmacen },
		url: '../controlador/almacen.php?op=activar',
		type: "POST",
		beforeSend: function () { }
	});
}
