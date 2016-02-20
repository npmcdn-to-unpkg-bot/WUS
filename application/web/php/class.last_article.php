<?php
	/**
	* 
	*/
	class LastArticle {
		
		private $bdd;
		private $_TABLES;
		private $type_item_article = 'article';

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getLastArticles() {

			if (session_status() == PHP_SESSION_NONE) {
			    session_start();
			}

			$articles = null;

			if(isset($_SESSION['user_subscription'])) {

				if(count($_SESSION['user_subscription']) > 0) {

					$user_subscription = join(',', $_SESSION['user_subscription']);

					if(isset($_COOKIE['category_preference'])) {

						$category_preference = json_decode(stripcslashes($_COOKIE['category_preference']), true);

						if(count($category_preference) > 0) {
							$ids = join(',', $category_preference);

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
										WHERE TI.type = :type AND WC.category_id IN ($ids) AND WC.website_id IN ($user_subscription)
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
									WHERE TI.type = :type AND WC.website_id IN ($user_subscription)
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