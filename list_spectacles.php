<?php
ini_set('display_errors', '1');
  // list of spectacles by zip code
  // using Spectacles object to print
require_once 'lib/Spectacles.class.php';
require_once 'include/connect.php';

require 'Mustache/Autoloader.php';
Mustache_Autoloader::register();

$pdo = connect();

  // nouvel objet spectacles -> input all spectacles in database
$spectacles = new Spectacles($pdo);

/*$spectacles->insert_data_from_api(1);*/

// list all zipcode available in databasegit a

// list spectacles for a given zipcode

$zip_code = $_REQUEST['zip_code'];



$spectacles_result['spectacles'] = $spectacles->find_spectacles_by_zipcode($zip_code);

/*var_dump($spectacles_result['spectacles']["pages"]);

foreach ($spectacles_result['spectacles']["pages"] as $key => $value) {
  echo "Key: $key; Value: $value<br />\n";
}

die;*/

/*
print_r($spectacles_result);
*/


$options =  array('extension' => '.html');

$m = new Mustache_Engine(array(

    'loader' => new Mustache_Loader_FilesystemLoader('assets/templates', $options)

                        )     );

//template used to generate elements 
echo $m->render('dataProject2',$spectacles_result);





    // préparer les champs
/*$spectacles->setUpdateFields(array());*/

  // enregistrer !
  // si on ajoute true en deuxième paramètre, on peut récupérer l'id du nouvel enregistrement
/*$new_id = $spectacles->setData(null,true);*/

  // récupérer (SELECT) le nouvel enregistrement
/*$new_row = $spectacles->getData($new_id);*/

  // afficher le nouvel enregistrement récupéré
/*print_r($new_row);*/
