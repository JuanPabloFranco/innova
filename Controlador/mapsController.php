<?php
include_once '../Modelo/Configuracion.php';
include_once '../DAO/configuracionDAO.php';

$dao = new configuracionDAO();
$dao->cargarInformacion();
// Reemplaza con tu API Key de Google Maps
$apiKey = $dao->objetos[0]->api_key_maps;

// Obtener los parámetros 'start' y 'end' desde la solicitud GET
$start = $dao->objetos[0]->punto_inicio_entrega;
$end = $_GET['fin'];

// Reemplaza espacios y otros caracteres especiales en las coordenadas
$start = urlencode($start);
$end = urlencode($end);

// URL de la API de Google Maps Directions
$url = "https://maps.googleapis.com/maps/api/directions/json?origin=$start&destination=$end&key=$apiKey";
// Iniciar la solicitud cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Cerrar la conexión cURL
curl_close($ch);

// Devolver la respuesta como JSON con el código de estado HTTP correspondiente
http_response_code($httpcode);
header('Content-Type: application/json');
echo $response;
?>
