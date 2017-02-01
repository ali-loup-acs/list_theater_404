<?php
// ini_set('display_errors', '1');
  // list of spectacles by zip code
  // using Spectacles object to print
require_once 'lib/Spectacles.class.php';
require_once 'include/connect.php';
require 'Mustache/Autoloader.php';

// here we deal with the vue part of the project: for pagination and spectacle details

// class to transform the table data with numerical indexes into exploitable ressources for Mustache
class IteratorPresenter implements IteratorAggregate
{
    private $values;

    public function __construct($values)
    {
        if (!is_array($values) && !$values instanceof Traversable) {
            throw new InvalidArgumentException('IteratorPresenter requires an array or Traversable object');
        }

        $this->values = $values;
    }

    public function getIterator()
    {
        $values = array();
        foreach ($this->values as $key => $val) {
            $values[$key] = array(
                'key'   => $key,
                'value' => $val,
                'first' => false,
                'last'  => false,
            );
        }

        $keys = array_keys($values);

        if (!empty($keys)) {
            $values[reset($keys)]['first'] = true;
            $values[end($keys)]['last']    = true;
        }

        return new ArrayIterator($values);
    }
}
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



    }
*/




/*    for ($i=1; $i <=count($spectacles_result['spectacles']['pages']) ; $i++) {
      $spectacles_result['spectacles']['pages'][->index = $spectacles_result['spectacles']['pages'][$i];
    }*/

/*foreach ($spectacles_result['spectacles']["pages"] as $key => $value) {
  echo "Key: $key; Value: $value<br />\n";
}*/

/*die;*/

/*
print_r($spectacles_result);
*/
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
