<?php

require_once '../Config/AutoLoad.php';

class API_GetPosts {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$post = new Post();

		if( empty($this->data['published']) )
			$posts = $post->findAll();
		else
			$posts = $post->findAllPublished();

		return json_encode( [ 'posts' => $posts ] );

	}

}	
?>