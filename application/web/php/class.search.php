<?php
	/**
	* 
	*/
	class Search {
		
		private $bdd;
		private $_TABLES;
		private $type_item_article = 'article';

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getSearch($searched) {

			// Recherche des données des articles en fonction de $searched

			try 
			{
				$sql = "SELECT I.*, W.website, W.logo, WC.website_id
						FROM " . $this->_TABLES['public']['Website'] . " W
						LEFT JOIN " . $this->_TABLES['public']['WebsiteCategory'] . " WC
						ON W.id = WC.website_id
						LEFT JOIN " . $this->_TABLES['public']['Item'] . " I
						ON WC.id = I.website_category_id
						LEFT JOIN " . $this->_TABLES['public']['TypeItem'] . " TI
						ON I.type_item_id = TI.id
						WHERE TI.type = :type AND $searched
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

		public function getSearchWithLimit($searched, $start, $limit) {

			// Recherche des données des articles en fonction de $searched

			try 
			{
				$sql = "SELECT I.*, W.website, W.logo, WC.website_id
						FROM " . $this->_TABLES['public']['Website'] . " W
						LEFT JOIN " . $this->_TABLES['public']['WebsiteCategory'] . " WC
						ON W.id = WC.website_id
						LEFT JOIN " . $this->_TABLES['public']['Item'] . " I
						ON WC.id = I.website_category_id
						LEFT JOIN " . $this->_TABLES['public']['TypeItem'] . " TI
						ON I.type_item_id = TI.id
						WHERE TI.type = :type AND $searched
						ORDER BY I.date_publication DESC
						LIMIT :start, :limit";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('type', $this->type_item_article, PDO::PARAM_STR);
				$req->bindValue('start', $start, PDO::PARAM_INT);
				$req->bindValue('limit', $limit, PDO::PARAM_INT);
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