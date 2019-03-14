<?php

require_once '../Config/AutoLoad.php';

class API_GetPost {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'id' => $this->data['id']
		];

		$validate = ValidateData::validate( $rule );

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		$post = new Post();

		$byId = $post->find( $this->data['id'] );

		if( $byId ){

			$tags = new PostTag();
			$tags = $tags->findByPost( $byId->id );

			return json_encode( [ 'post' => $byId, 'tag' => $tags ] );

		}
		else
			throw new CustomError('O post não existe', 404);

	}

}
	
?>