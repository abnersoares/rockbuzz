<?php
class CustomError {
    
    public function __construct($message = 'Not Found', $code = 404) {
        $this->execute( $message, $code );
    }

    public function execute( $message, $code ){

        header('X-PHP-Response-Code: '. $code, true, $code);

        echo json_encode(['message' => $message]);

        die();

    }
    
}
?>