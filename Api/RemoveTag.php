<?php

require_once '../Config/AutoLoad.php';

class API_RemoveTag {

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

		$tag = new Tag();

		$byId = $tag->find( $this->data['id'] );

		if( !$byId )
			throw new CustomError('A tag não existe', 404);

		if( $tag->delete( $this->data['id'] ) ){

			// REMOVE TODOS AS TAGS VINCULADAS AOS POSTS
			$post_tag = new PostTag();
			$post_tag->deleteByTag( $this->data['id'] );

			return json_encode( [ 'success' => true ] );

		}
		else
			throw new CustomError('Erro ao deletar a tag', 500);

	}

}
	
?>