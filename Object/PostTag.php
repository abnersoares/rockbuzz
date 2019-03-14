<?php

require_once '../Config/AutoLoad.php';

class PostTag extends Model {

	public $table = 'post_tag';

	private $post_id;
	private $tag_id;

	public function getPostId(){
		return $this->post_id;
	}

	public function setPostId( $post_id ){
		$this->post_id = $post_id;
	}

	public function getTagId(){
		return $this->tag_id;
	}

	public function setTagId( $tag_id ){
		$this->tag_id = $tag_id;
	}


	public function insert() {

		$sql = "INSERT INTO $this->table (post_id, tag_id) VALUES (:post_id, :tag_id)";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':post_id', $this->post_id, PDO::PARAM_INT);
		$stmt->bindParam(':tag_id', $this->tag_id, PDO::PARAM_INT);

		return $stmt->execute();

	}


	public function update( $id ) {
		return $id;
	}


	public function insertByPost( $post_id, $str_tags ){

		$tags 	  = explode(',', $str_tags);
		$tags_ids = [];

		foreach ($tags as $tag) {

			$tag_model = new Tag();
			$tag_find  = $tag_model->findByName( $tag );

			if( $tag_find )
				$tags_ids[] = $tag_find->id;
			else{

				$tag_model->setName( $tag );
				$tag_model->insert();

				$tags_ids[] = Database::getInstance()->lastInsertId();

			}

		}

		if( count($tags_ids) > 0 ){

			foreach ($tags_ids as $tag_id) {

				$post_tag = new PostTag();
				$post_tag->setPostId( $post_id );
				$post_tag->setTagId( $tag_id );
				$post_tag->insert();

			}

		}

	}


	public function findByPost( $post_id ) {

		$tag_model = new Tag();

		$sql  = "SELECT " . $tag_model->table . ".* FROM $this->table JOIN " . $tag_model->table . " ON " . $tag_model->table . ".id = " . $this->table . ".tag_id WHERE post_id = :post_id";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();

	}


	public function deleteByPost( $post_id ) {

		$sql  = "DELETE FROM $this->table WHERE post_id = :post_id";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
		
		return $stmt->execute();

	}

	public function deleteByTag( $tag_id ) {

		$sql  = "DELETE FROM $this->table WHERE tag_id = :tag_id";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
		
		return $stmt->execute();

	}

}

?>