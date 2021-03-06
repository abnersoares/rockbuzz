<?php

require_once '../Config/AutoLoad.php';

class Author extends Model {

	public $table = 'authors';

	private $name;

	public function getName(){
		return $this->name;
	}

	public function setName( $name ){
		$this->name = $name;
	}


	public function insert() {

		$sql = "INSERT INTO $this->table (name) VALUES (:name)";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':name', $this->name);

		return $stmt->execute();

	}


	public function update( $id ) {

		$sql = "UPDATE $this->table SET name = :name WHERE id = :id";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':id', $id);

		return $stmt->execute();

	}

}

?>