<?php
/*
*@param interval time beetween last update in hour
*return true if the value is under the variable interval else
*/
function test_interval_last_update($interval){
  $max_interval = $interval*60*60;
  $now = time();
  $last_modif = strtotime("2017-01-27 16:24:15");
  $current_interval = $now - $last_modif;
  if ($current_interval>$max_interval) {
    return false;
  }
  return true;

}

var_dump(test_interval_last_update(3)); // return false
var_dump(test_interval_last_update(100)); // return true
?>
