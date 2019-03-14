<?php

require_once '../Config/AutoLoad.php';

class Post extends Model {

	public $table = 'posts';

	private $title;
	private $slug;
	private $body;
	private $image;
	private $published;
	private $author_id;

	private $tags;

	public function getTitle(){
		return $this->title;
	}

	public function setTitle( $title ){
		$this->title = $title;
		$this->generateSlug( $title );
	}

	public function getSlug(){
		return $this->slug;
	}

	public function setSlug( $slug ){
		$this->slug = $slug;
	}

	public function generateSlug( $title ){
		
		$slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

		if( $this->findBySlug( $slug ) )
			$slug .= '-' . rand(10, 30);

		$this->slug = $slug;

	}

	public function getBody(){
		return $this->body;
	}

	public function setBody( $body ){
		$this->body = $body;
	}

	public function getImage(){
		return $this->image;
	}

	public function setImage( $image ){
		$this->image = $image;
	}

	public function getPublished(){
		return $this->published;
	}

	public function setPublished( $published ){
		$this->published = $published;
	}

	public function getAuthorId(){
		return $this->author_id;
	}

	public function setAuthorId( $author_id ){
		$this->author_id = $author_id;
	}

	public function getTags(){
		return $this->tags;
	}

	public function setTags( $tags ){
		$this->tags = $tags;
	}


	public function insert() {

		$sql = "INSERT INTO $this->table (title, slug, body, image, published, author_id) VALUES (:title, :slug, :body, :image, :published, :author_id)";
		$stmt = $pdo = Database::prepare( $sql );
		$stmt->bindParam(':title', $this->title);
		$stmt->bindParam(':slug', $this->slug);
		$stmt->bindParam(':body', $this->body);
		$stmt->bindParam(':image', $this->image);
		$stmt->bindParam(':published', $this->published);
		$stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);

		if( $stmt->execute() ){

			$post_id = Database::getInstance()->lastInsertId();

			// INSERE AS TAGS CASO HAJA
			if( !empty($this->tags) && $this->tags != 'undefined' ){

				$post_tag = new PostTag();
				$post_tag->insertByPost( $post_id, $this->tags );

			}

			return true;

		}else
			return false;

	}


	public function update( $id ) {

		$sql = "UPDATE $this->table SET title = :title, slug = :slug, body = :body, image = :image, published = :published, author_id = :author_id WHERE id = :id";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':title', $this->title);
		$stmt->bindParam(':slug', $this->slug);
		$stmt->bindParam(':body', $this->body);
		$stmt->bindParam(':image', $this->image);
		$stmt->bindParam(':published', $this->published);
		$stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);

		if( $stmt->execute() ){

			$post_id = $id;

			// INSERE AS TAGS CASO HAJA
			if( !empty($this->tags) && $this->tags != 'undefined' ){

				$post_tag = new PostTag();
				$post_tag->insertByPost( $post_id, $this->tags );

			}

			return true;

		}else
			return false;

	}

	public function chageStatus( $id, $published ) {

		$sql = "UPDATE $this->table SET published = :published WHERE id = :id";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':published', $published);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);

		return $stmt->execute();

	}


	public function find( $id ) {

		$author = new Author();

		$sql  = "SELECT " . $this->table . ".*, " . $author->table . ".name as author_name FROM $this->table JOIN " . $author->table . " ON " . $author->table . ".id = " . $this->table . ".author_id WHERE " . $this->table . ".id = :id";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();

	}

	public function findAll() {

		$author = new Author();

		$sql  = "SELECT " . $this->table . ".*, " . $author->table . ".name as author_name FROM $this->table JOIN " . $author->table . " ON " . $author->table . ".id = " . $this->table . ".author_id";
		$stmt = Database::prepare( $sql );
		$stmt->execute();

		return $stmt->fetchAll();

	}


	public function findAllPublished() {

		$author = new Author();

		$sql  = "SELECT " . $this->table . ".*, " . $author->table . ".name as author_name FROM $this->table JOIN " . $author->table . " ON " . $author->table . ".id = " . $this->table . ".author_id WHERE published = 1";
		$stmt = Database::prepare( $sql );
		$stmt->execute();

		return $stmt->fetchAll();

	}


	public function findBySlug( $slug ) {

		$author = new Author();

		$sql  = "SELECT " . $this->table . ".*, " . $author->table . ".name as author_name FROM $this->table JOIN " . $author->table . " ON " . $author->table . ".id = " . $this->table . ".author_id WHERE " . $this->table . ".slug = :slug";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':slug', $slug);
		$stmt->execute();

		return $stmt->fetch();

	}


	public function findByAuthor( $author_id ) {

		$sql  = "SELECT * FROM $this->table WHERE author_id = :author_id";
		$stmt = Database::prepare( $sql );
		$stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();

	}

}

?>