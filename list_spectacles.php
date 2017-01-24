<?php
  ini_set('display_errors', '1');
  // list of spectacles by zip code
  // using Spectacles object to print
  require_once 'Spectacles.class.php';
  require_once 'lib/connect.php';

  $pdo = connect();

  // nouvel objet spectacles
  $spectacles = new Spectacles($pdo);

  // préparer les champs
  /*$spectacles->setUpdateFields(array());*/

  // enregistrer !
  // si on ajoute true en deuxième paramètre, on peut récupérer l'id du nouvel enregistrement
  /*$new_id = $spectacles->setData(null,true);*/

  // récupérer (SELECT) le nouvel enregistrement
  /*$new_row = $spectacles->getData($new_id);*/

  // afficher le nouvel enregistrement récupéré
  /*print_r($new_row);*/

  $spectacles->insert_data_from_api(1);
