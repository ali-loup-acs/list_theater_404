<?php
// ini_set('display_errors', '1');
  // list of spectacles by zip code
  // using Spectacles object to print
require_once 'lib/Spectacles.class.php';
require_once 'include/connect.php';
require 'Mustache/Autoloader.php';
Mustache_Autoloader::register();

  if(isset($_REQUEST['zip_code'])){
    $pdo = connect();
    $spectacles = new Spectacles($pdo);
    if (false) {  // condition to update the data base
      $spectacles_result = $spectacles->insert_data_from_api(3);
  }

    $zip_code = $_REQUEST['zip_code'];
    $spectacles_result['spectacles'] = $spectacles->find_spectacles_by_zipcode($zip_code);
    $options =  array('extension' => '.html');

    $m = new Mustache_Engine(array(

      'loader' => new Mustache_Loader_FilesystemLoader('assets/templates', $options)

      )     );

      //template used to generate elements
      echo $m->render('dataProject2',$spectacles_result);
  }
  else { // redirection on index.php if no zipcode
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = '';
    header("Location: http://$host$uri/$extra");
    exit;
  }
