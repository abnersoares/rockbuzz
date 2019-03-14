<?php

require_once '../Config/AutoLoad.php';

class API_EditTag {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'name' => $this->data['name'],
			'id' => $this->data['id']
		];

		$validate = ValidateData::validate( $rule );

		$tag = new Tag();

		$byId = $tag->find( $this->data['id'] );

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		if( !$byId )
			throw new CustomError('A tag não existe', 400);

		if( $this->data['name'] != $byId->name && $tag->findByName( $this->data['name'] ) )
			throw new CustomError('A tag já existe', 400);

		$tag->setName( $this->data['name'] );

		if( $tag->update( $this->data['id'] ) )
			return json_encode( [ 'success' => true ] );
		else
			throw new CustomError('Erro ao salvar a tag', 500);

	}

}
	
?>