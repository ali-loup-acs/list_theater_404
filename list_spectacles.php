<?php
// ini_set('display_errors', '1');
  // list of spectacles by zip code
  // using Spectacles object to print
require_once 'lib/Spectacles.class.php';
require_once 'include/connect.php';

if(isset($_REQUEST['zip_code'])){
  $pdo = connect();

  // nouvel objet spectacles -> input all spectacles in database
  $spectacles = new Spectacles($pdo);
  // list all zipcode available in databasegit a
  $zip_code = $_REQUEST['zip_code'];

  // list spectacles for a given zipcode
  $spectacles_result = $spectacles->insert_data_from_api(3);
  print_r($spectacles_result);

}
else {
  $host  = $_SERVER['HTTP_HOST'];
  $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  $extra = '';
  header("Location: http://$host$uri/$extra");
  exit;
}
