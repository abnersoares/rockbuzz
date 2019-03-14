<?php
	
require_once '../Config/AutoLoad.php';

class API_GetUsers {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$user = new User();

		return json_encode( [ 'users' => $user->findAll() ] );

	}

}
	
?>