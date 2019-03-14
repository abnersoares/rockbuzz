<?php

require_once '../Config/AutoLoad.php';

class API_EditUser {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'name' => $this->data['name'],
			'email' => $this->data['email'],
			'id' => $this->data['id']
		];

		$validate = ValidateData::validate( $rule );

		$user = new User();

		$byId = $user->find( $this->data['id'] );

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		if( !$byId )
			throw new CustomError('O usuário não existe', 400);

		if( $this->data['email'] != $byId->email && $user->findByEmail( $this->data['email'] ) )
			throw new CustomError('E-mail já em uso', 500);

		$user->setName( $this->data['name'] );
		$user->setEmail( $this->data['email'] );

		if( empty($this->data['password']) || $this->data['password'] == 'undefinied' )
			$user->setPasswordMd5( $byId->password );
		else
			$user->setPassword( $this->data['password'] );

		if( $user->update( $this->data['id'] ) )
			return json_encode( [ 'success' => true ] );
		else
			throw new CustomError('Erro ao salvar o usuário', 500);

	}

}
	
?>