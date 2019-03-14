<?php

require_once '../Config/AutoLoad.php';

class API_AddPost {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'title' => $this->data['title'],
			'body' => $this->data['body'],
			'published' => $this->data['published'],
			'author_id' => $this->data['author_id']
		];

		$validate = ValidateData::validate( $rule );

		$post = new Post();

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		$author = new Author();
	
		if( !$author->find( $this->data['author_id'] ) )
			throw new CustomError('O autor não existe', 400);		

		// FAZ UPLOAD DA IMAGEM CASO HAJA
		if( !empty($this->data['image']) && $this->data['image'] != 'undefined' ){

			try {
				
				$ext  = explode(';', $this->data['image']);
				$ext  = explode('/', $ext[0]);
				$ext  = $ext[1];

				$name = date('YmdHis') . '.' . $ext;

				file_put_contents('../' . UPLOADS . '/' . $name, file_get_contents($this->data['image']));

				$post->setImage( $name );

			}
			catch( Exception $e ){

				throw new CustomError($e->getMessage(), 500);

			}

		}


		$post->setTitle( $this->data['title'] );
		$post->setBody( $this->data['body'] );
		$post->setPublished( $this->data['published'] );
		$post->setAuthorId( $this->data['author_id'] );
		$post->setTags( $this->data['tags'] );

		if( $post->insert() )
			return json_encode( [ 'success' => true ] );
		else
			throw new CustomError('Erro ao salvar o post', 500);

	}

}
	
?>