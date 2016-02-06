<?php
	/**
	* 
	*/
	class Website {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getData($id) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['Website'] . "
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->execute();
				$website = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($website) {
				return $website;
			}
			else {
				return null;
			}
		}

		public function getWebsites() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['Website'] . "
						WHERE scrap = :scrap
						ORDER BY website ASC";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('scrap', true, PDO::PARAM_BOOL);
				$req->execute();
				$websites = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($websites) {
				return $websites;
			}
			else {
				return null;
			}
		}

		public function getAllWebsites() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['Website'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$websites = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($websites) {
				return $websites;
			}
			else {
				return null;
			}
		}

		public function deleteWebsite($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['Website'] . "
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function editWebsite($id, $website, $url, $logo, $file, $scrap) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['Website'] . " 	
						SET website = :website, 
							url = :url,
							logo = :logo,
							file = :file,
							scrap = :scrap
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('website', $website, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('logo', $logo, PDO::PARAM_STR);
				$req->bindValue('file', $file, PDO::PARAM_STR);
				$req->bindValue('scrap', $scrap, PDO::PARAM_BOOL);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createWebsite($website, $url, $logo, $file, $scrap) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['Website'] . " (website, url, logo, file, scrap) VALUES (:website, :url, :logo, :file, :scrap)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('website', $website, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('logo', $logo, PDO::PARAM_STR);
				$req->bindValue('file', $file, PDO::PARAM_STR);
				$req->bindValue('scrap', $scrap, PDO::PARAM_BOOL);
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