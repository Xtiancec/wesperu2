var tabla;
init();
//funcion que se ejecuta al inicio
function init() {
    listar();

    $.post("../controlador/salida.php?op=selectExistencia", function (r) {
        // Load options into the #idExistencia select element
        $("#idExistencia").html(r);
        $("#idExistencia").select2();

        // Add a default option
        $("#idExistencia").prepend('<option disabled selected value="">Seleccione o escriba una existencia</option>');

        // Refresh the select2 plugin
        $("#idExistencia").trigger('change');


    });


    $.post("../controlador/salida.php?op=selectOT", function (r) {
        $("#idOT").html(r);
        $("#idOT").select2();
        $("#idOT").append('<option disabled selected value="">seleccione o escriba la OT</option>');
        $("#idOT").select2('refresh');
    });

    $.post("../controlador/salida.php?op=selectTipoSalida", function (r) {
        $("#idTiposalida").html(r);
        $("#idTiposalida").select2();
        $("#idTiposalida").append('<option disabled selected value="">seleccione el tipo de salida</option>');
        $("#idTiposalida").select2('refresh');
    });

    $.post("../controlador/salida.php?op=selectEmpleado", function (r) {
        $("#idEmpleado").html(r);
        $("#idEmpleado").select2();
        $("#idEmpleado").append('<option disabled selected value="">Seleccione o escriba el empleado</option>');
        $("#idEmpleado").select2('refresh');
    });

    $.post("../controlador/salida.php?op=selectExistencia", function (r) {
        $("#idExistenciaUpdate").html(r);
        $("#idExistenciaUpdate").select2();
        $("#idExistenciaUpdate").append('<option disabled selected value="">seleccione o escriba una existencia</option>');
        $("#idExistenciaUpdate").select2('refresh');

    });
    $.post("../controlador/salida.php?op=selectOT", function (r) {
        $("#idOTUpdate").html(r);
        $("#idOTUpdate").select2();
        $("#idOTUpdate").append('<option disabled selected value="">seleccione o escriba la OT</option>');
        $("#idOTUpdate").select2('refresh');
    });

    $.post("../controlador/salida.php?op=selectTipoSalida", function (r) {
        $("#idTiposalidaUpdate").html(r);
        $("#idTiposalidaUpdate").select2();
        $("#idTiposalidaUpdate").append('<option disabled selected value="">seleccione el tipo de salida</option>');
        $("#idTiposalidaUpdate").select2('refresh');
    });

    $.post("../controlador/salida.php?op=selectEmpleado", function (r) {
        $("#idEmpleadoUpdate").html(r);
        $("#idEmpleadoUpdate").select2();
        $("#idEmpleadoUpdate").append('<option disabled selected value="">Seleccione o escriba el empleado</option>');
        $("#idEmpleadoUpdate").select2('refresh');
    });


}

document.addEventListener('DOMContentLoaded', function () {
    let idExistencia = document.getElementById('idExistencia');
    let cantidad = document.getElementById('cantidad');
    let costoUnitario = document.getElementById('costoUnitario');
    let guardarRegistroButton = document.getElementById('guardarRegistroButton');
    let total = document.getElementById('subTotal');
    // Agregar un evento 'input' al input de cantidad

    cantidad.addEventListener('input', function () {
        calcularCostoReal();
        calcularSubtotal();
    });

    // Agregar un evento 'change' al select de idExistencia
    idExistencia.addEventListener('change', function () {
        calcularCostoReal();
    });

    // Agregar un evento de clic al botón para guardar el registro
    guardarRegistroButton.addEventListener('click', function (event) {
        event.preventDefault(); // Prevenir la recarga de la página (comportamiento predeterminado del botón submit)
        guardar();
    });

    function calcularCostoReal() {
        // Obtener los valores actuales de idExistencia y cantidad
        let idExistenciaValue = idExistencia.value;
        let cantidadValue = parseFloat(cantidad.value); // Convierte a número
    
        if (!isNaN(cantidadValue)) { // Verifica que cantidadValue sea un número válido
            // Realizar una solicitud AJAX al servidor
            $.ajax({
                data: {
                    "idExistencia": idExistenciaValue,
                    "cantidad": cantidadValue
                },
                url: '../controlador/salida.php?op=calcularCostoReal',
                type: "POST",
                beforeSend: function () { },
                success: function (data) {
                    console.log(data);
                    try {
                        var jsonData = JSON.parse(data);
                        console.log(jsonData);
    
                        // Accede al valor de costoUnitario directamente
                        var costoUnitarioValue = jsonData.costoUnitario.costoUnitario;
    
                        if (!isNaN(parseFloat(costoUnitarioValue))) {
                            // Asigna el valor al input 'costoUnitario'
                            document.getElementById('costoUnitario').value = costoUnitarioValue;
                            
                            // Llama a calcularSubtotal para actualizar el subtotal
                            calcularSubtotal();
                        } else {
                            // Establece el valor del input en blanco si no es válido
                            document.getElementById('costoUnitario').value = "";
                        }
                    } catch (e) {
                        console.error("Respuesta no válida JSON:", data);
                        toastr.error("No se pudo obtener el precio actual", "Error");
                    }
                },
                error: function (error) {
                    console.error(error);
                    toastr.error("No se pudo obtener el precio actual", "Error");
                }
            });
        } else {
            // Establece el valor del input en blanco si cantidadValue no es un número válido
            document.getElementById('costoUnitario').value = "";
        }
    }
    
    
    function calcularSubtotal() {
        let cantidadValue = parseFloat(cantidad.value);
        let costoUnitarioValue = parseFloat(costoUnitario.value);

        if (!isNaN(cantidadValue) && !isNaN(costoUnitarioValue)) {
            let subtotalValue = cantidadValue * costoUnitarioValue;
            total.value = subtotalValue.toFixed(2);
        } else {
            total.value = "";
        }
    }

   
    
});


function guardar() {
    var idExistencia = $('#idExistencia').val();
    var idTiposalida = $('#idTiposalida').val();
    var idOT = $('#idOT').val();
    var idEmpleado = $('#idEmpleado').val();
    var fecha = $('#fecha').val();
    var cantidad = $('#cantidad').val();
    var subTotal = $('#subTotal').val();

    var costoUnitario = document.getElementById('costoUnitario').value; // Corrección aquí

    var parametros = {
        "idExistencia": idExistencia,
        "idTiposalida": idTiposalida,
        "idOT": idOT,
        "idEmpleado": idEmpleado,
        "fecha": fecha,
        "cantidad": cantidad,
        "costoUnitario": costoUnitario,
        "subTotal": subTotal
    };

    $.ajax({
        data: parametros,
        url: '../controlador/salida.php?op=guardar',
        type: "POST",
        beforeSend: function () { },
        success: function (response) {
            if (response == "success") {
                $("#formularioregistro").modal("hide");
                Toastify({
                    text: "¡Se guardo correctamente los datos!",
                    duration: 3000, // Duración en milisegundos
                }).showToast();
            } else if (response == "requerid") {
                toastr.error("Complete los campos requeridos", "Campos incompletos");
            } else {
                toastr.error("Comuníquese con el proveedor", "ERROR");
            }
        },
        error: function (error) {
            console.error(error);
        },
        complete: function () {
            tabla.ajax.reload();
        }
    });
}






function ingresoStock() {

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
                { extend: 'pageLength', className: 'btn' }
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
            url: '../controlador/salida.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "columnDefs": [
            {
                "targets": 7, // Indica la columna "Monto"
                "render": function (data, type, row) {
                    return 'S/ ' + parseFloat(data).toFixed(2); // Agrega el símbolo y formatea el número
                }
            },
            {
                "targets": 8, // Indica la columna "Monto"
                "render": function (data, type, row) {
                    return 'S/ ' + parseFloat(data).toFixed(2); // Agrega el símbolo y formatea el número
                }
            }
        ],
        "bDestroy": true,

        "order": [[0, "desc"]]//ordenar (columna, orden)
    }).DataTable();
}



function mostrar(idSalida) {

    $.ajax({
        data: { "idSalida": idSalida },
        url: '../controlador/salida.php?op=mostrar',
        type: "post",
        beforeSend: function () { },
        success: function (response) {
            console.log(response)
            data = $.parseJSON(response);
            $("#idSalidaUpdate").val(data['idSalida']);
            $("#idExistenciaUpdate").val(data['idExistencia']);
            $("#idTiposalidaUpdate").val(data['idTiposalida']);
            $("#idOTUpdate").val(data['idOT']);
            $("#idEmpleadoUpdate").val(data['idEmpleado']);
            $("#fechaUpdate").val(data['fecha']);
            $("#cantidadUpdate").val(data['cantidad']);
            $("#costoUnitarioUpdate").val(data['costoUnitario']);
            $("#subTotalUpdate").val(data['subTotal']);
        }
    })
}



function Actualizar() {
    idSalida = $('#idSalidaUpdate').val();
    idExistencia = $('#idExistenciaUpdate').val();
    idTiposalida = $('#idTiposalidaUpdate').val();
    idOT = $('#idOTUpdate').val();
    idEmpleado = $('#idEmpleadoUpdate').val();
    fecha = $('#fechaUpdate').val();
    cantidad = $('#cantidadUpdate').val();
    costoUnitario = $('#costoUnitarioUpdate').val();
    subTotal = $('#subTotalUpdate').val();

    parametros = {
        "idSalida": idSalida,
        "idExistencia": idExistencia,
        "idTiposalida": idTiposalida,
        "idOT": idOT,
        "idEmpleado": idEmpleado,
        "fecha": fecha,
        "cantidad": cantidad,
        "costoUnitario": costoUnitario,
        "subTotal": subTotal
    }

    $.ajax({
        data: parametros,
        url: '../controlador/salida.php?op=editar',
        type: "POST",
        beforeSend: function () { },
        success: function (response) {
            console.log(response);
            if (response == "success") {
                tabla.ajax.reload();
                $("#formularioActualizar").modal("hide");
            } else if (response == "requerid") {
                toastr.error("Complete los datos por favor", "Datos incompletos");
            } else {
                toastr.error("Comuníquese con el administrador", "ERROR");
            }
        }
    });
}





