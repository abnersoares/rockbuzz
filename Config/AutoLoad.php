<?php
define('ROOT', dirname(dirname(__FILE__)) . '/');

function my_autoloader($class) {

	$class = str_replace('API_', '', $class);
	$class = str_replace('_', '', $class);

	if( file_exists( ROOT . 'Object/' . $class . '.php') )
    	require_once ROOT . 'Object/' . $class . '.php';
    elseif( file_exists( ROOT . 'Api/' . $class . '.php') )
    	require_once ROOT . 'Api/' . $class . '.php';
    elseif( file_exists( ROOT . 'Config/' . $class . '.php') )
    	require_once ROOT . 'Config/' . $class . '.php';

}

spl_autoload_register('my_autoloader');
?>