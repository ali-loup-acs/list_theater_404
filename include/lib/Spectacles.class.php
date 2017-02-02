<?php

require_once('Dao.class.php');
require_once('Api.class.php');

/*
*
*/

class Spectacles extends Dao // utilisation d'une classe d'accés aux données DAO data access object -> look for class php dao
{


public function __construct($pdo=null) //
{

  $this->table = 'spectacles'; //
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


/*
*
* @return array with zipcodes of all spectacles
*/

public function spectacles_zip_code($zip_code){

  $query = 'AND zip_code REGEXP \'^'.$zip_code.'\' GROUP BY zip_code';
  $this->setQuery($query);
  $results = $this->findData('zip_code', 'ASC');

  return $results;
}

/*
*@param int $zip_code zip code of spectacles
*@param int $limit number of result by page
*@param int $offset offset use for the page
*@return array $data spectacles by zip code
*/

public function find_spectacles_by_zip_code($zip_code=null, $limit=6, $offset=0){ //recupere des spectacles

  if (!empty($zip_code)) {
    $query = 'AND zip_code REGEXP \'^'.$zip_code.'\' GROUP BY zip_code';
  }

  // for the followings, check class Dao
  $this->setQuery($query);
  $this->limitData($limit, $offset);

  $data = $this->findData(null,'ASC');

  return $data;
}

/*
*@param $nb_days scale time in day for get the spectacles
*insert data for each spectale into the database using class Api
*@see class Api
*/

private function insert_data_from_api($nb_day = 7){

  $api = new Api();
  $results = $api->find_next_spectacles($nb_day);

  foreach ($results as $key => $value) {

    $this->setUpdateFields(array(
      'title' => $value['title'],
      'object_show' => $value['object'],
      'zip_code' => $value['zip_code'],
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

/*
*@var int $zip_code zip code
*@return boolean true if valid else false
*/
public function is_valid_zip_code($zip_code){

  if (is_int($zip_code) && (strlen((string)$zip_code)<=5)) {
    return true;
  }

  return false;
}

/*
*
*@return string $last_date_update date of the last insertion from the data base
*/
public function last_date_update()
{
  //initialization
  $last_date_update = "0000-00-00 00:00:00";
  $res = $this->findData('date_insert','ASC');

  if (!empty($res)) {
    $last_date_update = $res[0]['date_insert'];
  }

  return $last_date_update;
}

/*
*@param int $interval  interval time beetween last update in hour
*return true if the value is under the variable interval else
*/
private function test_interval_last_date_update($interval=6){

  $max_interval = $interval*60*60;// convert the hour in second
  $now = time();
  $last_modif = strtotime($this->last_date_update()); // convert date into unix time stamp
  $current_interval = $now - $last_modif;
  if ($current_interval>$max_interval) {
    return false;
  }

  return true;
}

/*
*@param int $days date limit
*initalization of the database
*/
public function init($day = 7){
  $this->insert_data_from_api($day);
}

/*
*@param int $intervalinterval hour to proceed the update
* test if last update has been processed in a time scale of more than time given here 3 hours and 6 hours per default
*/
public function update_spectacles($interval=6){

  if (!$this->test_interval_last_date_update(3)) {
    $this->reset();
    $this->init();
  }
}

/*
*reset the table !
*@see table
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
