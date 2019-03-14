<?php

require_once '../Config/AutoLoad.php';

class API_AddUser {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'name' => $this->data['name'],
			'email' => $this->data['email'],
			'password' => $this->data['password']
		];

		$validate = ValidateData::validate( $rule );

		$user = new User();

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		if( $user->findByEmail( $this->data['email'] ) )
			throw new CustomError('E-mail já em uso', 500);

		$user->setName( $this->data['name'] );
		$user->setEmail( $this->data['email'] );
		$user->setPassword( $this->data['password'] );

		if( $user->insert() )
			return json_encode( [ 'success' => true ] );
		else
			throw new CustomError('Erro ao salvar o usuário', 500);

	}

}
	
?>