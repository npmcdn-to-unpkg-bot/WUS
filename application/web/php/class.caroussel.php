<?php
	/**
	* 
	*/
	class Caroussel {
		
		private $bdd;
		private $_TABLES;
		private $type_item_article = 'article';
		private $limit = 5;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getCaroussel() {

			try 
			{
				$sql = "SELECT I.*, W.website, W.logo
						FROM " . $this->_TABLES['public']['Website'] . " W
						LEFT JOIN " . $this->_TABLES['public']['Category'] . " C
						ON W.id = C.website_id
						LEFT JOIN " . $this->_TABLES['public']['Item'] . " I
						ON C.id = I.category_id
						LEFT JOIN " . $this->_TABLES['public']['TypeItem'] . " TI
						ON I.type_item_id = TI.id
						WHERE TI.type = :type
						ORDER BY date_publication DESC
						LIMIT :limit";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('type', $this->type_item_article, PDO::PARAM_STR);
				$req->bindValue('limit', $this->limit, PDO::PARAM_INT);
				$req->execute();
				$caroussel = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($caroussel) {
				return $caroussel;
			}
			else {
				return null;
			}
		}
	}
?>