<?php

require_once '../Config/AutoLoad.php';

class API_GetTags {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$tag = new Tag();

		return json_encode( [ 'tags' => $tag->findAll() ] );

	}

}
	
?>