<?php

require_once '../Config/AutoLoad.php';

class API_Login {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'email' => $this->data['email'],
			'password' => $this->data['password']
		];

		$validate = ValidateData::validate( $rule );

		$user = new User();

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		$credential = $user->findByCredentials( $this->data['email'], $this->data['password'] );

		if( !$credential )
			throw new CustomError('Erro de credenciais', 400);
		else{

			$_SESSION['credential'] = [
				'date' => date('Y-m-d'),
				'time' => date('H:i:s'),
				'user' => $credential
			];

			return json_encode( [ 'success' => true ] );

		}

	}

}
	
?>