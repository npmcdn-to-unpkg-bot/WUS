<?php
	/**
	* 
	*/
	class CategoryPreference {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getAllCategoryPreferences() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['CategoryPreference'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$category_preferences = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($category_preferences) {
				return $category_preferences;
			}
			else {
				return null;
			}
		}

		public function deleteCategoryPreference($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['CategoryPreference'] . "
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

		public function editCategoryPreference($id, $user_id, $category_id) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['CategoryPreference'] . " 	
						SET user_id = :user_id, category_id = :category_id
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('user_id', $user_id, PDO::PARAM_INT);
				$req->bindValue('category_id', $category_id, PDO::PARAM_INT);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createCategoryPreference($user_id, $category_id) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['CategoryPreference'] . " (user_id, category_id) VALUES (:user_id, :category_id)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('user_id', $user_id, PDO::PARAM_INT);
				$req->bindValue('category_id', $category_id, PDO::PARAM_INT);
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