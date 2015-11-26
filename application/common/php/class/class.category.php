<?php
	/**
	* 
	*/
	class Category {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getAllCategories() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['Category'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$categories = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($categories) {
				return $categories;
			}
			else {
				return null;
			}
		}

		public function deleteCategory($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['Category'] . "
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

		public function editCategory($id, $category) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['Category'] . " 	
						SET category = :category
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('category', $category, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createCategory($category) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['Category'] . " (category) VALUES (:category)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('category', $category, PDO::PARAM_STR);
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