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

    $this->table = 'spectacles';
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
     );


}
  function get_(){ //recupere un spectacle

  }

  function find_spectacles(){ //recupere des spectacles

  }

  function insert_data_from_api($nb_day = 7){
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
}

?>


