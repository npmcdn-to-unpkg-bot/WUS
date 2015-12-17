<?php
	/**
	* 
	*/
	class Timeline {
		
		private $bdd;
		private $_TABLES;
		private $type_item_article = 'article';

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getTimeline() {

			// Rechercher les cookies de preferences
			// 
			// Effectuer la requete des articles en fonction des category

			if(isset($_COOKIE['category_preference'])) {
				$category_preference = $_COOKIE['category_preference'];

				try 
				{
					$sql = "SELECT I.*, W.website, W.logo
							FROM " . $this->_TABLES['public']['Website'] . " W
							LEFT JOIN " . $this->_TABLES['public']['WebsiteCategory'] . " WC
							ON W.id = WC.website_id
							LEFT JOIN " . $this->_TABLES['public']['Item'] . " I
							ON WC.id = I.website_category_id
							LEFT JOIN " . $this->_TABLES['public']['TypeItem'] . " TI
							ON I.type_item_id = TI.id
							WHERE TI.type = :type AND WC.category_id IN :category_preference
							ORDER BY date_publication DESC";
					$req = $this->bdd->prepare($sql);
					$req->bindValue('type', $this->type_item_article, PDO::PARAM_STR);
					$req->bindValue('category_preference', $category_preference, PDO::PARAM_STR);
					$req->execute();
					$articles = $req->fetchAll(PDO::FETCH_OBJ);
				}
				catch (PDOException $e)
				{
				    error_log($sql);
				    error_log($e->getMessage());
				    die();
				}
			} else {
				try 
				{
					$sql = "SELECT I.*, W.website, W.logo
							FROM " . $this->_TABLES['public']['Website'] . " W
							LEFT JOIN " . $this->_TABLES['public']['WebsiteCategory'] . " WC
							ON W.id = WC.website_id
							LEFT JOIN " . $this->_TABLES['public']['Item'] . " I
							ON WC.id = I.website_category_id
							LEFT JOIN " . $this->_TABLES['public']['TypeItem'] . " TI
							ON I.type_item_id = TI.id
							WHERE TI.type = :type
							ORDER BY date_publication DESC";
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