<?php
	/**
	* 
	*/
	class Preference {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getAllPreferenceByUser($user_id) {
			
			try 
			{
				$sql = "SELECT * FROM " . $this->_TABLES['public']['CategoryPreference'] . " WHERE user_id = :user_id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('user_id', $user_id, PDO::PARAM_INT);
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

		public function removeAllPreferenceByUser($user_id) {
			
			try 
			{
				$sql = "DELETE FROM " . $this->_TABLES['public']['CategoryPreference'] . " WHERE user_id = :user_id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('user_id', $user_id, PDO::PARAM_INT);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function addPreferenceByUser($user_id, $category_id) {
			
			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['CategoryPreference'] . "(user_id, category_id) VALUES (:user_id, :category_id)";
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