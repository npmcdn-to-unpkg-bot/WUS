<?php
	/**
	* 
	*/
	class StaticPage {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getAllStaticPages() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['StaticPage'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$static_pages = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($static_pages) {
				return $static_pages;
			}
			else {
				return null;
			}
		}

		public function deleteStaticPage($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['StaticPage'] . "
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

		public function editStaticPage($id, $title, $url, $path) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['StaticPage'] . " 	
						SET title = :title, 
							url = :url,
							path = :path
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('title', $title, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('path', $path, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createStaticPage($title, $url, $path) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['StaticPage'] . " (title, url, path) VALUES (:title, :url, :path)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('title', $title, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('path', $path, PDO::PARAM_STR);
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