<?php

header("Content-type:application/json");

require_once '../Config/AutoLoad.php';

if( !empty($_GET['op']) && file_exists( $_GET['op'] . '.php' ) ){

	$data = json_decode( file_get_contents("php://input"), true );

	$class_name = 'API_' . $_GET['op'];
	$obj = new $class_name( $data );

	// SALVA LOG
	$log = Log::save( $class_name, $data );

	echo $obj->execute();

}
else
	throw new CustomError();

?>