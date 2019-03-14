<?php

require_once '../Config/AutoLoad.php';

class User extends Model {

	public $table = 'users';

	private $name;
	private $email;
	private $password;

	public function getName(){
		return $this->name;
	}

	public function setName( $name ){
		$this->name = $name;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail( $email ){
		$this->email = $email;
	}

	public function setPassword( $password ){
		$this->password = md5($password);
	}

	public function setPasswordMd5( $password ){
		$this->password = $password;
	}


	public function insert() {

		$sql = "INSERT INTO $this->table (name, email, password) VALUES (:name, :email, :password)";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':password', $this->password);

		return $stmt->execute();

	}


	public function update( $id ) {

		$sql = "UPDATE $this->table SET name = :name, email = :email, password = :password WHERE id = :id";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':password', $this->password);
		$stmt->bindParam(':id', $id);

		return $stmt->execute();

	}

	public function findByEmail( $email ) {

		$sql  = "SELECT * FROM $this->table WHERE email = :email";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':email', $email);
		$stmt->execute();

		return $stmt->fetch();

	}

	public function findByCredentials( $email, $password) {

		$password = md5($password);

		$sql  = "SELECT * FROM $this->table WHERE email = :email AND password = :password";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':password', $password);
		$stmt->execute();

		return $stmt->fetch();

	}

}

?>