<?php

require_once '../Config/AutoLoad.php';

class API_GetAuthor {

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

		if( $byId )
			return json_encode( [ 'author' => $byId ] );
		else
			throw new CustomError('O autor não existe', 404);

	}

}
	
?>