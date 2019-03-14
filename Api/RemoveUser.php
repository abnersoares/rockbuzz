<?php

require_once '../Config/AutoLoad.php';

class API_RemoveUser {

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

		if( !$byId )
			throw new CustomError('A tag não existe', 404);

		if( $user->delete( $this->data['id'] ) )
			return json_encode( [ 'success' => true ] );
		else
			throw new CustomError('Erro ao deletar a tag', 500);

	}

}
	
?>