<?php

require_once '../Config/AutoLoad.php';

class API_AddTag {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'name' => $this->data['name']
		];

		$validate = ValidateData::validate( $rule );

		$tag = new Tag();

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		if( $tag->findByName( $this->data['name'] ) )
			throw new CustomError('A tag já existe', 400);

		$tag->setName( $this->data['name'] );

		if( $tag->insert() )
			return json_encode( [ 'success' => true ] );
		else
			throw new CustomError('Erro ao salvar a tag', 500);

	}

}
	
?>