<?php
class ValidateData {

	public static function validate( $data ) {

		foreach ($data as $key => $value) {
			if( !isset($value) )
				return ['validated' => false, 'field' => $key];
		}

		return ['validated' => true];

	}

}
?>