<?php
require_once('include/require.php');
require_once('include/lib/IteratorPresenter.class.php');
define('NB_BY_PAGE',6);

$spectacles = new Spectacles();

$zip_code =  '';
$offset = 0;
$nb_by_page = 6;
$spectacles_result = array();

if(isset($_REQUEST['zip_code'])){
  $zip_code = $_REQUEST['zip_code'];
}
<<<<<<< HEAD
=======
Mustache_Autoloader::register();

  if(isset($_REQUEST['zip_code'])/*&&isset($_REQUEST['page'])*/){
    /*$current_page = $_REQUEST['page'];*/
    $zip_code = $_REQUEST['zip_code'];
    $pdo = connect();
    $spectacles = new Spectacles($pdo);

    $spectacles_result['spectacles'] = $spectacles->find_spectacles_by_zipcode($zip_code/*$current_page*/);
    /*print_r($spectacles_result);*/

    $spectacles_result['pages'] = new IteratorPresenter($spectacles->pagerData()['pages']);

    // print_r($spectacles_result);
    // print_r($spectacles->pagerData());

 // How many spectacles in the table?
/*    foreach ($pager as $key => $value) {

      foreach ($pager[0][$key] as $key => $value) {
        echo "Key: $key; Value: $value<br />\n";
      }

>>>>>>> 6a4fcfffe45f9b882f2f42ec7f30d0d23e0c60c9

if (isset($_REQUEST['offset'])){
  $offset = $_REQUEST['offset'];
}

if ($spectacles->is_valid_zip_code($zip_code)) {
  $spectacles_result['spectacles'] = $spectacles->find_spectacles_by_zip_code($zip_code,NB_BY_PAGE,$offset);
} else {
  $spectacles->limitData(NB_BY_PAGE,$offset);
  $spectacles_result['spectacles'] = $spectacles->findData();
}

<<<<<<< HEAD
$spectacles_result['pages'] = new IteratorPresenter($spectacles->pagerData()['pages']); // reformat the numeric array to an associative array
$spectacles_result['zip_code'] = $zip_code;

render_template('list_spectacles',$spectacles_result);
=======
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
>>>>>>> 6a4fcfffe45f9b882f2f42ec7f30d0d23e0c60c9
