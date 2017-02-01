<?php
header('Content-type: application/json');

require 'include/require.php';

$list_spectacles = array();
$zip_code = ""; // zip code search

if(isset($_REQUEST['zip_code'])&&!empty($_REQUEST['zip_code'])){

  $zip_code = $_REQUEST['zip_code'];
  $spectacles = new Spectacles();
  $list_spectacles = $spectacles->spectacles_zip_code($zip_code);
}
echo json_encode($list_spectacles);
?>
