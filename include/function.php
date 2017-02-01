<?php
function render_template($template,$data=null){

Mustache_Autoloader::register();
$options =  array('extension' => '.html');
$m = new Mustache_Engine(array(
  'loader' => new Mustache_Loader_FilesystemLoader(TEMPLATES_PATH, $options)
));

echo $m->render($template,$data);

}
