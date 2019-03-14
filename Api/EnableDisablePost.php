<?php

require_once '../Config/AutoLoad.php';

class API_EnableDisablePost {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$rule = [
			'id' => $this->data['id'],
			'action' => $this->data['action']
		];

		$validate = ValidateData::validate( $rule );

		if( !$validate['validated'] )
			throw new CustomError('O campo "' . $validate['field'] . '" é obrigatório', 400);

		$post = new Post();

		if( !$post->find( $this->data['id'] ) )
			throw new CustomError('O post não existe', 400);

		$published = 1;

		if( $this->data['action'] == 'disable' )
			$published = 0;

		return json_encode( [ 'success' => $post->chageStatus( $this->data['id'], $published ) ] );

	}

}
	
?>