<?php

require_once '../Config/AutoLoad.php';

class API_GetLogs {

	public function __construct ( $data = null ){
		$this->data = $data;
	}

	public function execute(){

		$log = new Log();

		return json_encode( [ 'logs' => $log->findAll() ] );

	}

}
	
?>