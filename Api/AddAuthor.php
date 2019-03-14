<?php

require_once '../Config/AutoLoad.php';

class API_AddAuthor {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'name' => $this->data['name']
		];

		$validate = ValidateData::validate( $rule );

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		$author = new Author();
		$author->setName( $this->data['name'] );

		if( $author->insert() )
			return json_encode( [ 'success' => true ] );
		else
			throw new CustomError('Erro ao salvar o autor', 500);

	}

}
	
?>