<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos
    $token = 'apis-token-6397.Lmx17dsxx-Ohh00Fi-eeORJX6gQMMECC';

    // Verifica si se ha enviado el RUC
    if (isset($_POST['ruc'])) {
        $ruc = $_POST['ruc'];

        // Iniciar llamada a API
        $curl = curl_init();

        // Buscar ruc sunat
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apis.net.pe/v2/sunat/ruc?numero=' . $ruc,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Referer: http://apis.net.pe/api-ruc',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        // Datos de empresas según padron reducido
        $empresa = json_decode($response);

        // Devuelve la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode($empresa);
    } else {
        // Si no se envió el RUC, devolver algún mensaje de error
        echo json_encode(array('error' => 'No se proporcionó el RUC.'));
    }
} else {
    // Si la solicitud no es de tipo POST, devolver un mensaje de error
    echo json_encode(array('error' => 'Solicitud no válida.'));
}
?>
