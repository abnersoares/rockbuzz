<?php
	
require_once '../Config/AutoLoad.php';

class API_GetAuthors {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$author = new Author();

		return json_encode( [ 'authors' => $author->findAll() ] );

	}

}
	
?>