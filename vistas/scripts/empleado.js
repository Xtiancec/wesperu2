var tabla;
init();

//funcion que se ejecuta al inicio
function init() {
    listar();
    $.post("../controlador/empleado.php?op=selectBanco", function (r) {
        $("#idBanco").html(r);
        $("#idBanco").select2();
        $("#idBanco").append('<option disabled selected value="">seleccione un banco</option>');
        $("#idBanco").select2('refresh');
    });

    $.post("../controlador/empleado.php?op=selectCargo", function (r) {
        $("#idCargo").html(r);
        $("#idCargo").select2();
        $("#idCargo").append('<option disabled selected value="">Seleccione el cargo</option>');
        $("#idCargo").select2('refresh');
    });
}


function guardar() {


    $(document).ready(function () {

        $('#formularioregistros').click(function () {
            $('#formularioregistros').show();
      

        });
    });


    $(document).on('submit', '#formulario', function (e) {
        e.preventDefault();
        var idCargo = $('#idCargo').val();
        var idBanco = $('#idBanco').val();
        var tipoDocumento = $('#tipoDocumento').val();
        var numeroDocumento = $('#numeroDocumento').val();       
        var nombre = $('#nombre').val();
        var apellidoPaterno = $('#apellidoPaterno').val();
        var apellidoMaterno = $('#apellidoMaterno').val();
        var telefono = $('#telefono').val();
        var personaContacto = $('#personaContacto').val();
        var telefonoEmergencia = $('#telefonoEmergencia').val();
        var correo = $('#correo').val();
        var direccion = $('#direccion').val();
        var distrito = $('#distrito').val();
        var fechaNacimiento = $('#fechaNacimiento').val();
        var fechaIngreso = $('#fechaIngreso').val();
        var tipoSeguro = $('#tipoSeguro').val();
        var fechaSeguroVida = $('#fechaSeguroVida').val();
        var numeroCuenta = $('#numeroCuenta').val();
        var informacionAdicional = $('#informacionAdicional').val();
        var estado = $('#estado').val();

        $.ajax({
            type: 'POST',
            url: '../controlador/empleado.php?op=guardar',
            data: {
                idCargo: idCargo,
                idBanco: idBanco,
                tipoDocumento: tipoDocumento,
                numeroDocumento: numeroDocumento,
                nombre: nombre,
                apellidoPaterno: apellidoPaterno,
                apellidoMaterno: apellidoMaterno,
                telefono: telefono,
                personaContacto: personaContacto,
                telefonoEmergencia: telefonoEmergencia,
                correo: correo,
                direccion: direccion,
                distrito: distrito,
                fechaNacimiento: fechaNacimiento,
                fechaIngreso: fechaIngreso,
                tipoSeguro: tipoSeguro,
                fechaSeguroVida: fechaSeguroVida,
                numeroCuenta: numeroCuenta,
                informacionAdicional: informacionAdicional,
                estado: estado
            },

            success: function (response) {
                console.log(response);

                $('#formularioregistros').modal('hide');
                $('#idCargo').val('');
                $('#idBanco').val('');
                $('#tipoDocumento').val('');
                $('#numeroDocumento').val('');
                $('#nombre').val('');
                $('#apellidoPaterno').val('');
                $('#apellidoMaterno').val('');
                $('#telefono').val('');
                $('#personaContacto').val('');
                $('#telefonoEmergencia').val('');
                $('#correo').val('');
                $('#direccion').val('');
                $('#distrito').val('');

                $('#fechaNacimiento').val('');
                $('#fechaIngreso').val('');
                $('#tipoSeguro').val('');
                $('#fechaSeguroVida').val('');
                $('#numeroCuenta').val('');
                $('#informacionAdicional').val('');
                $('#estado').val('');

            }

        });
        $(document).on('click', '.close', function () {
            $('#formularioregistros').hide();
        });
        tabla.ajax.reload();
    })

    //funcion para guardaryeditar
}



//cancelar form
function cancelarform() {
    limpiar();
    mostrarform(false);
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
            url: '../controlador/empleado.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,

        "order": [[0, "desc"]]//ordenar (columna, orden)
    }).DataTable();
}

function limitarLongitud(input, maxLength) {
	if (input.value.length > maxLength) {
	  input.value = input.value.slice(0, maxLength); // Truncar el valor a la longitud máxima
	}
  }

function validarMinimo(input, min) {
    if (input.value < min) {
        input.setCustomValidity('El valor debe ser mayor o igual a ' + min+' digitos');
    } else {
        input.setCustomValidity('');
    }
}

function validarTexto(input) {
    var valor = input.value;

    // Expresión regular que permite solo letras (mayúsculas o minúsculas) y espacios en blanco
    var regex = /^[A-Za-z\s]*$/;

    if (!regex.test(valor)) {
        input.value = valor.replace(/[^A-Za-z\s]/g, ''); // Elimina cualquier carácter que no sea letra o espacio
    }
}
//funcion mostrar formulario


