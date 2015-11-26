<?php
	/**
	* 
	*/
	class SystemPreference {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getSystemPreference() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['SystemPreference'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$system_preference = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($system_preference) {
				return $system_preference;
			}
			else {
				return null;
			}
		}

		public function editSystemPreference($url_facebook, $url_instagram, $url_twitter, $url_rss, $url_sitemap, $counter_caroussel) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['SystemPreference'] . " 	
						SET url_facebook = :url_facebook,
						url_instagram = :url_instagram,
						url_twitter = :url_twitter,
						url_rss = :url_rss,
						url_sitemap = :url_sitemap,
						counter_caroussel = :counter_caroussel";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('url_facebook', $url_facebook, PDO::PARAM_STR);
				$req->bindValue('url_instagram', $url_instagram, PDO::PARAM_STR);
				$req->bindValue('url_twitter', $url_twitter, PDO::PARAM_STR);
				$req->bindValue('url_rss', $url_rss, PDO::PARAM_STR);
				$req->bindValue('url_sitemap', $url_sitemap, PDO::PARAM_STR);
				$req->bindValue('counter_caroussel', $counter_caroussel, PDO::PARAM_INT);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}
	}
?>