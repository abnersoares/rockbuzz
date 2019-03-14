<?php

require_once '../Config/AutoLoad.php';

class API_GetTag {

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

		if( $byId )
			return json_encode( [ 'tag' => $byId ] );
		else
			throw new CustomError('A tag não existe', 404);

	}

}
	
?>