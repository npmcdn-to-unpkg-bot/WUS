<?php
	/**
	* 
	*/
	class Collaboration {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getAllCollaborations() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['Collaboration'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$collaborations = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($collaborations) {
				return $collaborations;
			}
			else {
				return null;
			}
		}

		public function deleteCollaboration($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['Collaboration'] . "
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

		public function editCollaboration($id, $collaboration, $url, $image) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['Collaboration'] . " 	
						SET collaboration = :collaboration, 
							url = :url,
							image = :image
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('collaboration', $collaboration, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('image', $image, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createCollaboration($collaboration, $url, $image) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['Collaboration'] . " (collaboration, url, image) VALUES (:collaboration, :url, :image)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('collaboration', $collaboration, PDO::PARAM_STR);
				$req->bindValue('url', $url, PDO::PARAM_STR);
				$req->bindValue('image', $image, PDO::PARAM_STR);
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