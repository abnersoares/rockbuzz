<?php

require_once '../Config/AutoLoad.php';

class API_EditPost {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'title' => $this->data['title'],
			'body' => $this->data['body'],
			'published' => $this->data['published'],
			'author_id' => $this->data['author_id'],
			'id' => $this->data['id']
		];

		$validate = ValidateData::validate( $rule );

		$post = new Post();

		$byId = $post->find( $this->data['id'] );

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		if( !$byId )
			throw new CustomError('O post não existe', 400);

		$author = new Author();
	
		if( !$author->find( $this->data['author_id'] ) )
			throw new CustomError('O autor não existe', 400);

		// FAZ UPLOAD DA IMAGEM CASO HAJA
		if( !empty($this->data['image']) && $this->data['image'] != 'undefined' && count(explode($byId->image, $this->data['image'])) == 1 ){

			try {
				
				$ext  = explode(';', $this->data['image']);
				$ext  = explode('/', $ext[0]);
				$ext  = $ext[1];

				$name = date('YmdHis') . '.' . $ext;

				file_put_contents('../' . UPLOADS . '/' . $name, file_get_contents($this->data['image']));

				$post->setImage( $name );

				if( !empty($byId->image) && file_exists( '../' . UPLOADS . '/' . $byId->image ) )
					unlink( '../' . UPLOADS . '/' . $byId->image );

			}
			catch( Exception $e ){

				throw new CustomError($e->getMessage(), 500);

			}

		}else
			$post->setImage( $byId->image );


		$post_tag = new PostTag();
		$post_tag->deleteByPost( $byId->id );


		$post->setTitle( $this->data['title'] );
		$post->setSlug( $byId->slug );
		$post->setBody( $this->data['body'] );
		$post->setPublished( $this->data['published'] );
		$post->setAuthorId( $this->data['author_id'] );
		$post->setTags( $this->data['tags'] );


		if( $post->update( $this->data['id'] ) )
			return json_encode( [ 'success' => true ] );
		else
			throw new CustomError('Erro ao salvar o post', 500);

	}

}
	
?>