<?php
  class Api{

    private $entry_point = 'http://www.theatre-contemporain.net/'; // Point d'entrée

    private $api_request = 'api/spectacles/all/search?'; // Requête (OBJET = identifiant unique)

    private $api_key = 'API_KEY'; // Clé API

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
    public function find_next_spectacles($days, $arr=true ){

      $this->set($days);
      if($arr){
        $infos_spectacles_json = json_decode($this->exec());
        $spectacles= array();
        $spectacles['title'] = $infos_spectacles_json[0]->title;
        $spectacles['object'] = $infos_spectacles_json[0]->object;
        $spectacles['zipcode'] = $infos_spectacles_json[0]->near_dates->zipcode;
        $spectacles['city'] = $infos_spectacles_json[0]->near_dates->city;
        $spectacles['permanent_url_show'] = $infos_spectacles_json[0]->permanent_url;
        $spectacles['permanent_url_place'] = $infos_spectacles_json[0]->near_dates->place->permanent_url;
        $spectacles['start'] = $infos_spectacles_json[0]->near_dates->start;
        $spectacles['end'] =  $infos_spectacles_json[0]->near_dates->end;
        $spectacles['poster'] = $infos_spectacles_json[0]->poster;
        return $spectacles;
      }
      else{
        return json_decode($this->exec());
      }
    }
  }
?>
