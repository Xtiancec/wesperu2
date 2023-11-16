$(document).ready(function () {
    // Capturar el evento de envío del formulario
    $("#formulario").submit(function (e) {
        e.preventDefault(); // Evitar que el formulario se envíe normalmente

        // Obtener los valores del formulario
        var idEmpleado = $("#idEmpleado").val();
        var idOT = $("#idOT").val();
        var idTiposalida = $("#idTiposalida").val();
        var idExistencia = $("#idExistencia").val();
        var fecha = $("#fecha").val();
        var cantidad = $("#cantidad").val();

        // Combinar los datos en un solo objeto
        var data = {
            idEmpleado: idEmpleado,
            idOT: idOT,
            idTiposalida: idTiposalida,
            idExistencia: idExistencia,
            fecha: fecha,
            cantidad: cantidad
        };

        // Enviar los datos al servidor a través de una sola solicitud AJAX
        $.ajax({
            type: "POST",
            url: "../controlador/salidas.php",
            data: data, // Enviar todos los datos en un solo objeto
            dataType: "json",  // Espera una respuesta JSON del servidor
            success: function (response) {
                if (response.success) {
                    // Manejar la respuesta exitosa
                    alert(response.message);
                    // Actualizar los campos de costo unitario FIFO y subtotal en el formulario
                    $("#costoUnitarioFIFO").val(response.costoUnitarioFIFO);
                    var subtotal = cantidad * response.costoUnitarioFIFO;
                    $("#subtotal").val(subtotal);
                } else {
                    // Manejar errores
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
});
