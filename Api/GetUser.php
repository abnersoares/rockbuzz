<?php

require_once '../Config/AutoLoad.php';

class API_GetUser {

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

		$user = new User();

		$byId = $user->find( $this->data['id'] );

		if( $byId )
			return json_encode( [ 'user' => $byId ] );
		else
			throw new CustomError('O usuário não existe', 404);

	}

}
	
?>