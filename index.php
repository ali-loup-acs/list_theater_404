<?php

require 'Mustache/Autoloader.php';
Mustache_Autoloader::register();

$options =  array('extension' => '.html');

$m = new Mustache_Engine(array(

    'loader' => new Mustache_Loader_FilesystemLoader('assets/templates', $options)

                        )     );

echo $m->render('dataProject',array());




?>
