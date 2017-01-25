<?php
  ini_set('display_errors', '1');
  include('lib/Spectacles.class.php');
  require_once 'include/connect.php';

  $zip_code = ""; // zip code search

  if(isset($_REQUEST['search'])&&!empty($_REQUEST['search'])){

    $zip_code = $_REQUEST['search'];
  }
  header('Content-type: application/json');
  $pdo = connect();
  $spectacles = new Spectacles($pdo);
  $array_spectacles = $spectacles->spectacles_zipcode($zip_code);
  foreach ($array_spectacles as $key => $value) {
    $array_spectacles[$key]['url'] = 'audinetta.php';
  }
  echo empty($zip_code) ? "" : json_encode($array_spectacles);


?>
