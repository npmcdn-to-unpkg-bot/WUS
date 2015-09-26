<?php
	/**
	* 
	*/
	class Bar {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getItem($guidItem) {
			
			try 
			{
				$sql = "SELECT I.*, W.website, W.logo
						FROM " . $this->_TABLES['public']['Website'] . " W
						LEFT JOIN " . $this->_TABLES['public']['Category'] . " C
						ON W.id = C.website_id
						LEFT JOIN " . $this->_TABLES['public']['Item'] . " I
						ON C.id = I.category_id
						WHERE I.guid = :guid";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('guid', $guidItem, PDO::PARAM_STR);
				$req->execute();
				$item = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($item) {
				return $item;
			}
			else {
				return null;
			}
		}
	}
?>