<?php
ini_set('display_errors', '1');
  // list of spectacles by zip code
  // using Spectacles object to print
require_once 'lib/Spectacles.class.php';
require_once 'include/connect.php';

$pdo = connect();

  // nouvel objet spectacles -> input all spectacles in database
$spectacles = new Spectacles($pdo);

/*$spectacles->insert_data_from_api(1);*/

// list all zipcode available in database

// list spectacles for a given zipcode

// $zip_code = $_REQUEST['zip_code'];

$spectacles_result = $spectacles->spectacles_zipcode('25');

print_r($spectacles_result);





    // préparer les champs
/*$spectacles->setUpdateFields(array());*/

  // enregistrer !
  // si on ajoute true en deuxième paramètre, on peut récupérer l'id du nouvel enregistrement
/*$new_id = $spectacles->setData(null,true);*/

  // récupérer (SELECT) le nouvel enregistrement
/*$new_row = $spectacles->getData($new_id);*/

  // afficher le nouvel enregistrement récupéré
/*print_r($new_row);*/
