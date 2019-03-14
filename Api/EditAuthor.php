<?php

require_once '../Config/AutoLoad.php';

class API_EditAuthor {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'name' => $this->data['name'],
			'id' => $this->data['id']
		];

		$validate = ValidateData::validate( $rule );

		$author = new Author();

		$byId = $author->find( $this->data['id'] );

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		if( !$byId )
			throw new CustomError('O autor não existe', 400);

		$author->setName( $this->data['name'] );

		if( $author->update( $this->data['id'] ) )
			return json_encode( [ 'success' => true ] );
		else
			throw new CustomError('Erro ao salvar o autor', 500);

	}

}
	
?>