<?php
require "../modelos/Salidas.php"; // Asegúrate de que la ruta sea correcta

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idExistencia = $_POST["idExistencia"];
    $cantidad = $_POST["cantidad"];

    // Crear una instancia de la clase Salidas
    $salidas = new Salidas();

    // Llamar al método registrarSalida para realizar el registro
    $result = $salidas->registrarSalida($idExistencia, $cantidad);

    if (is_numeric($result)) {
        // Éxito: La salida se registró correctamente
        echo json_encode(array("success" => true, "message" => "Salida registrada correctamente.", "costoUnitarioFIFO" => $result));
    } else {
        // Error: Ocurrió un problema al registrar la salida
        echo json_encode(array("success" => false, "message" => "Error al registrar la salida: $result"));
    }
} else {
    // Si no se recibieron datos por POST, mostrar un mensaje de error
    echo json_encode(array("success" => false, "message" => "Error: No se recibieron datos del formulario."));
}
?>
