var tabla;
init();
//funcion que se ejecuta al inicio
function init() {
    listar();
    $.post("../controlador/existencia.php?op=selectSubclase", function (r) {
        $("#idSubclase").html(r);
        $("#idSubclase").select2();
        $("#idSubclase").append('<option disabled selected value="">subclase</option>');
    });

    $.post("../controlador/existencia.php?op=selectUM", function (r) {
        $("#idUM").html(r);
        $("#idUM").select2();
        $("#idUM").append('<option disabled selected value="">Unidad Medida</option>');
    });

    $.post("../controlador/existencia.php?op=selectSubclase", function (r) {
        $("#idSubclaseUpdate").html(r);        
        $("#idSubclaseUpdate").select2();
        $("#idSubclase").Select2('refresh');
    });

    $.post("../controlador/existencia.php?op=selectUM", function (r) {
        $("#idUMUpdate").html(r);
        $("#idUMUpdate").select2();
        $("#idSubclase").Select2('refresh');
    });
}

function mostrar(idExistencia){
	$.ajax({
		data:{"idExistencia":idExistencia},
		url:'../controlador/existencia.php?op=mostrar',
		type:"post",
		beforeSend:function(){},
		success: function(response){
			console.log(response)
			data=$.parseJSON(response);
                $("#idExistenciaUpdate").val(data['idExistencia']);
				$("#idSubclaseUpdate").val(data['idSubclase']);
				$("#idUMUpdate").val(data['idUM']);
				$("#nombreUpdate").val(data['nombre']);	
		}
	})
}

function guardar() {
    idSubclase = $('#idSubclase').val();
    idUM = $('#idUM').val();
    nombre = $('#nombre').val();
    stockInicial = $('#stockInicial').val();
    precioActual = $('#precioActual').val();
    // Obtener el estado del checkbox
    autorizacion = $('#autorizacion').is(':checked') ? 'si' : 'no';

    parametros = {
        "idSubclase": idSubclase,
        "idUM": idUM,
        "nombre": nombre,
        "stockInicial": stockInicial,
        "precioActual": precioActual,
        "autorizacion": autorizacion
    };

    $.ajax({
        data: parametros,
        type: 'POST',
        url: '../controlador/existencia.php?op=guardar',
        beforeSend: function () {},
        success: function (response) {
            if (response == "success") {
                console.log(response);
                tabla.ajax.reload();
                $("#formularioregistro").modal("hide");
                toastr.success("Se guardó correctamente los datos", "Registro exitoso");
            } else if (response == "requerid") {
                toastr.error("Complete todos los campos requeridos por favor", "Campos incompletos!");
            } else {
                toastr.error("Comuníquese con su proveedor", "Error!");
            }
        }
    });
    tabla.ajax.reload();
}

function Actualizar(){
    idExistencia=$('#idExistenciaUpdate').val();
	idUM=$('#idUMUpdate').val();
	idSubclase=$('#idSubclaseUpdate').val();
	nombre=$('#nombreUpdate').val();
	autorizacion=$('#autorizacion').val();

	parametros ={"idExistencia":idExistencia,"idUM":idUM,"idSubclase":idSubclase,"nombre":nombre,"autorizacion":autorizacion}
	$.ajax({
		data: parametros,
		url: '../controlador/existencia.php?op=editar',
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

//funcion listar
function listar() {
    tabla = $('#tbllistado').DataTable({
        dom: 'lBfrtip',
		buttons:['copy', 'csv', 'excel', 'pdf', 'print'],
        displayLength: 10, // Cambiado de "displayLength" a "length" para la cantidad de registros por página
        ajax: {
            url: '../controlador/existencia.php?op=listar',
            type: "GET",
            dataType: "json",
            error: function (xhr, status, error) {
                console.log(error);
            }
        },
        destroy: true,
        order: [[5, "desc"]]
    });
}


//funcion para desactivar
function confirmarEliminacion(idExistencia) {
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


function desactivar(idExistencia) {
	$.ajax({
		data: { "idExistencia": idExistencia },
		url: '../controlador/existencia.php?op=desactivar',
		type: "POST",
		beforeSend: function () { }		
	});
}

//funcion para desactivar
function confirmarActivacion(idExistencia) {

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
				activar(idExistencia);
				tabla.ajax.reload();
			}else{
				swal("cancelado","el registro no fue activado","error");
			}
		});
	});
}

function activar(idExistencia) {
	$.ajax({
		data: { "idExistencia": idExistencia },
		url: '../controlador/existencia.php?op=activar',
		type: "POST",
		beforeSend: function () { }
	});
}
