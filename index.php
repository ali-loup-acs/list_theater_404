<?php

require 'Mustache/Autoloader.php';
include 'lib/Spectacles.class.php';
include 'include/connect.php';
$pdo = connect();
$spec = new Spectacles($pdo);

//initialization of the data base with spectacles
// update Spectacles
$spec->update_spectacles();

Mustache_Autoloader::register();

$options =  array('extension' => '.html');

$m = new Mustache_Engine(array(

    'loader' => new Mustache_Loader_FilesystemLoader('assets/templates', $options)

                        )     );

echo $m->render('dataProject',array());

?>
