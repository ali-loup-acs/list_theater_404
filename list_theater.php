<?php
  ini_set('display_errors', '1');
  include_once('lib/Api.class.php');
  $api = new Api();
  print_r($api->find_next_spectacles(1));
 ?>
