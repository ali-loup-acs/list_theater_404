<?php
// Get info from API in Json format

  class Api{

    private $entry_point = 'http://www.theatre-contemporain.net/'; // Point d'entrée

    private $api_request = 'api/spectacles/all/search?'; // Requête (OBJET = identifiant unique)

    private $api_key = '53e87c5bc7607ad500e29fd0a955af5f7e38c457'; // Clé API

    private $api_call;

    function __construct(){

      $this->api_call = $this->init();
    }
    function init(){

      return curl_init();
    }

    private function set($days){

      $today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
      $next  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+$days, date("Y")));
      $period = 'period=true&from='.$today.'&to='.$next;
      $curl = $this->entry_point.$this->api_request.$period.'&k='.$this->api_key;
      $api_call_options = array(
        CURLOPT_URL => $curl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('Content-type: application/json'),
      );


      curl_setopt_array($this->api_call, $api_call_options);
    }

    private function exec(){

      return curl_exec($this->api_call);
    }

    private function close(){

      curl_close($this->api_call);
    }

    /*
      @days : period for spectacles by days
      @arr : format array or json
      return an array with spectacles during @days day
    */

    // creation of table successively sent to database
    public function find_next_spectacles($days, $arr=true ){

      $this->set($days); //
      if($arr){
        $infos_spectacles = json_decode($this->exec());
        $spectacles= array();

        foreach ($infos_spectacles as $key => $value) {
          $spectacles[$key]['title'] = $infos_spectacles[$key]->title;
          $spectacles[$key]['object'] = $infos_spectacles[$key]->object;
          $spectacles[$key]['zip_code'] = $infos_spectacles[$key]->near_dates->zipcode;
          $spectacles[$key]['city'] = $infos_spectacles[$key]->near_dates->city;
          $spectacles[$key]['permanent_url_show'] = $infos_spectacles[$key]->permanent_url;
          $spectacles[$key]['permanent_url_place'] = $infos_spectacles[$key]->near_dates->place->permanent_url;
          $spectacles[$key]['start'] = $infos_spectacles[$key]->near_dates->start;
          $spectacles[$key]['end'] =  $infos_spectacles[$key]->near_dates->end;
          $spectacles[$key]['poster'] = $infos_spectacles[$key]->poster;
        }
        return $spectacles;
      }
      else{
        return $this->exec();
      }
    }
  }
?>
