<?php

require_once '../Config/Config.php';

class Log {

	private function getUserIP() {

	    $ipaddress = '';

	    if (isset($_SERVER['HTTP_CLIENT_IP']))
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_X_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if(isset($_SERVER['HTTP_FORWARDED']))
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];
	    else if(isset($_SERVER['REMOTE_ADDR']))
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
	    else
	        $ipaddress = 'UNKNOWN';

	    return $ipaddress;

	}

    public static function save( $request = null, $data = null ){

    	$request = str_replace('API_', '', $request);

    	if( $request == 'GetLogs' )
    		return true;

    	if( !empty($data['password']) )
    		$data['password'] = '#####';

    	$log = [
    		'date' => date('Y-m-d H:i:s'),
    		'url' => URL . 'API/' . $request,
    		'data' => $data,
    		'client_agent' => $_SERVER["HTTP_USER_AGENT"],
    		'client_ip' => self::getUserIP()
    	];


    	$json 	= self::findAll();
		$json[] = $log;
		

        $fp = fopen("../" . LOG_FILE, "w");
        fwrite($fp, json_encode($json));
        fclose($fp);

        return true;

    }

    public function findAll() {

    	$fp   = fopen("../" . LOG_FILE, "r");
    	$json = '';
    	
    	while( !feof($fp) )
    		$json .= fgets($fp, 1024);
		
		fclose($fp);

		if( !empty($json) )
			$json = json_decode($json, true);
		else
			$json = [];

		return $json;

    }
    
}
?>