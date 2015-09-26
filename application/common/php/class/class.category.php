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

		public function getCategories($website_id) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['Category'] . "
						WHERE website_id = :website_id
						ORDER BY category ASC";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('website_id', $website_id, PDO::PARAM_INT);
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
	}
?>