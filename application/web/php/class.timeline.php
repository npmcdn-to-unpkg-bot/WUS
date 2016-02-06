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

				$category_preference = json_decode(stripcslashes($_COOKIE['category_preference']), true);

				if(count($category_preference) > 0) {
					$ids = join(',', $category_preference);

					if(isset($_COOKIE['media_preference'])) {

						$media_preference = json_decode(stripcslashes($_COOKIE['media_preference']), true);

						if(count($media_preference) > 0) {
							$media_ids = join(',', $media_preference);

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
										WHERE TI.type = :type AND WC.category_id IN ($ids) AND WC.website_id IN ($media_ids)
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
						} else {
							$articles = null;
						}
					} else {
						// Requete classique
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
									WHERE TI.type = :type AND WC.category_id IN ($ids)
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
					}
				} else {
					$articles = null;
				}			
			} else if(isset($_COOKIE['user_preference'])) {

				$user_preference = json_decode(stripcslashes($_COOKIE['user_preference']), true);

				if(count($user_preference) > 0) {
					$ids = join(',', $user_preference);

					if(isset($_COOKIE['media_preference'])) {

						$media_preference = json_decode(stripcslashes($_COOKIE['media_preference']), true);

						if(count($media_preference) > 0) {
							$media_ids = join(',', $media_preference);

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
										WHERE TI.type = :type AND WC.category_id IN ($ids) AND WC.website_id IN ($media_ids)
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
						} else {
							$articles = null;
						}
					} else {
						// Requete classique
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
									WHERE TI.type = :type AND WC.category_id IN ($ids)
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
					}
				} else {
					$articles = null;
				}
			} else {

				if(isset($_COOKIE['media_preference'])) {

					$media_preference = json_decode(stripcslashes($_COOKIE['media_preference']), true);

					if(count($media_preference) > 0) {
						$media_ids = join(',', $media_preference);

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
									WHERE TI.type = :type AND WC.website_id IN ($media_ids)
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
					} else {
						$articles = null;
					}
				} else {
					// Requete classique
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