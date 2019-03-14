<?php

require_once '../Config/AutoLoad.php';

class API_GetPostBySlug {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'slug' => $this->data['slug']
		];

		$validate = ValidateData::validate( $rule );

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		$post = new Post();

		$bySlug = $post->findBySlug( $this->data['slug'] );

		if( $bySlug ){

			$tags = new PostTag();
			$tags = $tags->findByPost( $bySlug->id );

			return json_encode( [ 'post' => $bySlug, 'tag' => $tags ] );

		}
		else
			throw new CustomError('O post não existe', 404);

	}

}
	
?>