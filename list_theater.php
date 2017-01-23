<?php
$apiRequest = '/api/contacts/'; // Requête (OBJET = identifiant unique)

$start = '0'; // Debut de l'offset

$end = '5'; // Fin de l'offset

$apiKey = 'KEY'; // Clé API

$entryPoint = 'http://www.theatre-contemporain.net'; // Point d'entrée

// initialiser CURL et définir les options
$apiCall = curl_init($entryPoint.$apiRequest.'?k='.$apiKey);
$apiCallOptions = array(
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array('Content-type: application/json'),
);
curl_setopt_array($apiCall, $apiCallOptions);

// récupèrer les résultats
$result =  json_decode(curl_exec($apiCall));

// faire un print des résultats
echo '<pre>'.print_r($result,true).'</pre>';


// $json = json_decode(file_get_contents('assets/samples/sample.json'));
// print_r(get_theater_by_region('1',$json));

function get_theater_by_region($id_region, $arr){
  $theater = "";

  return $theaters;
}
 ?>
