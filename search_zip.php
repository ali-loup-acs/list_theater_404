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
  echo empty($zip_code) ? "" : json_encode($spectacles->spectacles_zipcode($zip_code));
?>
