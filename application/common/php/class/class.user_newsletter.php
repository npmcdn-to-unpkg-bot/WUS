<?php
	/**
	* 
	*/
	class UserNewsletter {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		// Custom

		public function getData($id) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['UserNewsletter'] . "
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->execute();
				$user = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($user) {
				return $user;
			}
			else {
				return null;
			}
		}

		public function getExist($email) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['UserNewsletter'] . "
						WHERE email = :email";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('email', $email, PDO::PARAM_STR);
				$req->execute();
				$user = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($user) {
				return $user;
			}
			else {
				return null;
			}
		}

		// General

		public function getAllUsersNewsletter() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['UserNewsletter'];
				$req = $this->bdd->prepare($sql);
				$req->execute();
				$users = $req->fetchAll(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($users) {
				return $users;
			}
			else {
				return null;
			}
		}

		public function deleteUserNewsletter($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['UserNewsletter'] . "
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

		public function editUserNewsletter($id, $email) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['UserNewsletter'] . " 	
						SET email = :email
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('email', $email, PDO::PARAM_STR);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createUserNewsletter($email) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['UserNewsletter'] . " (email) VALUES (:email)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('email', $email, PDO::PARAM_STR);
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