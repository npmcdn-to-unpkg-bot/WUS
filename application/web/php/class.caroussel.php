<?php

	require_once(dirname(dirname(dirname(__FILE__))) . "/common/php/class/class.system_preference.php");
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

			$objSystemPreference = new SystemPreference($bdd, $_TABLES);
        	$system_preference = $objSystemPreference->getSystemPreference();

        	if(!is_null($system_preference)) {

	            $this->limit = ((int)($system_preference->counter_carrousel));
	        }
		}

		public function getCaroussel() {

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