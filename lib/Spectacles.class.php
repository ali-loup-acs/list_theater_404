<?php

require_once('Dao.class.php');
require_once('Api.class.php');


/**
 *
 */

class Spectacles extends Dao // utilisation d'une classe d'accés aux données DAO data access object -> look for class php dao
{


  public function __construct($pdo) //
  {

    $this->table = 'spectacles'; // be cautious
    parent::__construct($pdo);
    $this->aliastable = 'sp';
    $this->idtable = 'id';
    $this->fields = array(
     'id',
     'title',
     'object_show',
     'zip_code',
     'city',
     'info_show',
     'info_place',
     'date_start',
     'date_end',
     'poster',
     'date_insert',
     );


  }
  function get_spectacle_by_name(){ //recupere un spectacle

  }



  function find_spectacles_by_zipcode($zipcode){ //recupere des spectacles

   $digits = strlen((string)$zipcode);
    $rest_digits = 5 - $digits;
    $query = "0";
    /*echo $digits;*/
    if ($digits<6) {// if less than five digits see REGEX function sql
      $query = "zip_code REGEXP '^$zipcode\[0-9\]{0,$rest_digits}$' GROUP BY zip_code";
    }

    $this->setQuery($query);

    $results = $this->findData(null,'ASC');

   return $results;
  }


  private function insert_data_from_api($nb_day = 7){
    $api = new Api();
    $results = $api->find_next_spectacles($nb_day);

    foreach ($results as $key => $value) {

    // this -> element courant à la classe

      $this->setUpdateFields(array(

        'title' => $value['title'],
        'object_show' => $value['object'],
        'zip_code' => $value['zipcode'],
        'city' => $value['city'],
       'info_show' => $value['permanent_url_show'], //?
       'info_place' => $value['permanent_url_place'], //?
       'date_start' => $value['start'],
       'date_end' => $value['end'],
       'poster' => $value['poster'],


       ));

      $this->setData();

    }


  }

  // return an array with zipcodes of all spectacles
  function spectacles_zipcode($zip){
    $digits = strlen((string)$zip);
    $rest_digits = 5 - $digits;
    $query = "0";
    if ($digits<6) {// if less than five digits see REGEX function sql
      $query = "zip_code REGEXP '^$zip\[0-9\]{0,$rest_digits}$' GROUP BY zip_code";
    }

    $this->setQuery($query);

    $results = $this->findData('zip_code', 'ASC');

   return $results;
  }
  public function last_date_update()
  {
    $this->setQuery('1');
    $res = $this->findData('date_insert','ASC');
    return $res[0]['date_insert'];
  }

  /*
  *@param $interval : interval time beetween last update in hour
  *return true if the value is under the variable interval else
  */
  private function test_interval_last_date_update($interval=6){
    $max_interval = $interval*60*60;
    $now = time();
    $last_modif = strtotime($this->last_date_update());
    $current_interval = $now - $last_modif;
    if ($current_interval>$max_interval) {
      return false;
    }
    return true;

  }

  /*
  *@param $days : spectacles until days
  *initalization of the database
  */
  public function init($day = 7){
    $this->insert_data_from_api($day);
  }

  /*
  *@param $interval : interval in hour for the verification of data spectacles on current time
  * update the database with new value from the api
  */
  public function update_spectacles($interval=6){
    if (!$this->test_interval_last_date_update(3)) {
      $this->reset();
      $this->init();
    }
  }
  /*
  *
  *truncate table
  */

  private function reset(){

    $sql = 'TRUNCATE TABLE '.$this->table;

    // statement
    $sth = $this->db->prepare($sql);
    $sth->execute();
    if (!$sth) {
      echo "\nPDO::errorInfo():\n";
      print_r($this->db->errorInfo());
      exit;
    }
  }
}
?>
