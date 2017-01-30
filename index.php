<?php

require 'Mustache/Autoloader.php';
include 'lib/Spectacles.class.php';
include 'include/connect.php';
$pdo = connect();
$spec = new Spectacles($pdo);
// $spec->insert_data_from_api(7);
$date=$spec->last_update();
echo($date);



Mustache_Autoloader::register();

$options =  array('extension' => '.html');

$m = new Mustache_Engine(array(

    'loader' => new Mustache_Loader_FilesystemLoader('assets/templates', $options)

                        )     );

echo $m->render('dataProject',array());

?>
