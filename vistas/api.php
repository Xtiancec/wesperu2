<?php
// Datos

if (isset($_GET['ruc'])) {
  $ruc = $_GET['ruc'];
  $apiURL = "https://api.apis.net.pe/v1/ruc?numero=" . $ruc;
  $consulta = file_get_contents($apiURL);


  header("Content-Type: application/json");
  echo $consulta;
}