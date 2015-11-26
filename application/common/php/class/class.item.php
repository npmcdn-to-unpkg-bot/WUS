<?php
	/**
	* 
	*/
	class Item {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getAllItems() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['Item'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$items = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($items) {
				return $items;
			}
			else {
				return null;
			}
		}

		public function deleteItem($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['Item'] . "
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function editItem($id, $type_item_id, $website_category_id, $guid, $url, $title, $width_image, $height_image, $image, $alt_image, $description, $date_publication, $author) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['Item'] . " 	
						SET type_item_id = :type_item_id,
						website_category_id = :website_category_id,
						guid = :guid,
						url = :url,
						title = :title,
						width_image = :width_image,
						height_image = :height_image,
						image = :image,
						alt_image = :alt_image,
						description = :description,
						date_publication = :date_publication,
						author = :author
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('type_item_id', $type_item_id, PDO::PARAM_INT);
				$req->bindValue('website_category_id', $website_category_id, PDO::PARAM_INT);
				$req->bindValue('guid', $guid, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('title', $title, PDO::PARAM_STR);
				$req->bindValue('width_image', $width_image, PDO::PARAM_INT);
				$req->bindValue('height_image', $height_image, PDO::PARAM_INT);
				$req->bindValue('image', $image, PDO::PARAM_STR);
				$req->bindValue('alt_image', $alt_image, PDO::PARAM_STR);
				$req->bindValue('description', $description, PDO::PARAM_STR);
				$req->bindValue('date_publication', $date_publication, PDO::PARAM_STR);
				$req->bindValue('author', $author, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createItem($type_item_id, $website_category_id, $guid, $url, $title, $width_image, $height_image, $image, $alt_image, $description, $date_publication, $author) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['Item'] . " (type_item_id,
						website_category_id,
						guid,
						url,
						title,
						width_image,
						height_image,
						image,
						alt_image,
						description,
						date_publication,
						author) VALUES (:type_item_id,
						:website_category_id,
						:guid,
						:url,
						:title,
						:width_image,
						:height_image,
						:image,
						:alt_image,
						:description,
						:date_publication,
						:author)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('type_item_id', $type_item_id, PDO::PARAM_INT);
				$req->bindValue('website_category_id', $website_category_id, PDO::PARAM_INT);
				$req->bindValue('guid', $guid, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('title', $title, PDO::PARAM_STR);
				$req->bindValue('width_image', $width_image, PDO::PARAM_INT);
				$req->bindValue('height_image', $height_image, PDO::PARAM_INT);
				$req->bindValue('image', $image, PDO::PARAM_STR);
				$req->bindValue('alt_image', $alt_image, PDO::PARAM_STR);
				$req->bindValue('description', $description, PDO::PARAM_STR);
				$req->bindValue('date_publication', $date_publication, PDO::PARAM_STR);
				$req->bindValue('author', $author, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}
	}
?>