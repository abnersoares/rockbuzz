<?php

require_once '../Config/AutoLoad.php';

class API_RemoveAuthor {

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

		$author = new Author();

		$byId = $author->find( $this->data['id'] );

		if( !$byId )
			throw new CustomError('O autor não existe', 404);

		if( $author->delete( $this->data['id'] ) ){

			// REMOVE TODOS OS POSTS DO USUÁRIO
			$posts = new Post();
			$posts = $posts->findByAuthor( $this->data['id'] );

			if( count($posts) > 0 ){
				foreach ($posts as $post) {

					if( !empty($post->image) && file_exists( '../' . UPLOADS . '/' . $post->image ) )
						unlink( '../' . UPLOADS . '/' . $post->image );
					
					$post_tag = new PostTag();
					$post_tag->deleteByPost( $post->id );

					$post_delete = new Post();
					$post_delete->delete( $post->id );

				}
			}

			return json_encode( [ 'success' => true ] );
		}
		else
			throw new CustomError('Erro ao deletar o autor', 500);

	}

}
	
?>