<?php

	require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/class/class.static_page.php");
	/**
	* 
	*/
	class Document {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getAllDocuments() {

			$objStaticPage = new StaticPage($this->bdd, $this->_TABLES);
			$documents = $objStaticPage->getAllStaticPages();

			if($documents) {
				return $documents;
			}
			else {
				return null;
			}
		}

		public function getDocument($url) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['StaticPage'] . " WHERE url = :url";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->execute();
				$document = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($document) {
				return $document;
			}
			else {
				return null;
			}
		}
	}
?>