<?php
	/**
	* 
	*/
	class TypeItem {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getAllTypeItems() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['TypeItem'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$type_items = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($type_items) {
				return $type_items;
			}
			else {
				return null;
			}
		}

		public function deleteTypeItem($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['TypeItem'] . "
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

		public function editTypeItem($id, $type) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['TypeItem'] . " 	
						SET type = :type
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('type', $type, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createTypeItem($type) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['TypeItem'] . " (type) VALUES (:type)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('type', $type, PDO::PARAM_STR);
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