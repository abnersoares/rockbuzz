<?php

require_once '../Config/AutoLoad.php';

class API_RemovePost {

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

			if( !empty($byId->image) && file_exists( '../' . UPLOADS . '/' . $byId->image ) )
				unlink( '../' . UPLOADS . '/' . $byId->image );

			$post_tag = new PostTag();
			$post_tag->deleteByPost( $byId->id );

		}
		else
			throw new CustomError('O post não existe', 404);

		if( $post->delete( $this->data['id'] ) )
			return json_encode( [ 'success' => true ] );
		else
			throw new CustomError('Erro ao deletar o post', 500);

	}

}
	
?>