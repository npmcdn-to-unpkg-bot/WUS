<?php
	/**
	* 
	*/
	class Rss {
		
		private $bdd;
		private $_TABLES;
		private $type_item_article = 'article';

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getAll() {

			//Recherche de tout les articles

			try 
			{
				$sql = "SELECT I.guid, I.title, I.url, I.description, I.date_publication, I.author
						FROM " . $this->_TABLES['public']['Website'] . " W
						LEFT JOIN " . $this->_TABLES['public']['WebsiteCategory'] . " WC
						ON W.id = WC.website_id
						LEFT JOIN " . $this->_TABLES['public']['Item'] . " I
						ON WC.id = I.website_category_id
						LEFT JOIN " . $this->_TABLES['public']['TypeItem'] . " TI
						ON I.type_item_id = TI.id
						WHERE TI.type = :type
						ORDER BY I.date_publication DESC";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('type', $this->type_item_article, PDO::PARAM_STR);
				$req->execute();
				$articles = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}		

			if($articles) {
				return $articles;
			}
			else {
				return null;
			}
		}
	}
?>