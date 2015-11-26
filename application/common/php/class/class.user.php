<?php
	/**
	* 
	*/
	class User {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getAllUsers() {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['public']['User'];
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

		public function deleteUser($id) {

			try 
			{
				$sql = "DELETE 
						FROM " . $this->_TABLES['public']['User'] . "
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

		public function editUser($id, $name, $login, $pass, $valid) {

			try 
			{
				$sql = "UPDATE " . $this->_TABLES['public']['User'] . " 	
						SET name = :name,
						login = :login,
						pass = SHA1(:pass),
						valid = :valid
						WHERE id = :id";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('id', $id, PDO::PARAM_INT);
				$req->bindValue('name', $name, PDO::PARAM_STR);
				$req->bindValue('login', $login, PDO::PARAM_STR);
				$req->bindValue('pass', $pass, PDO::PARAM_STR);
				$req->bindValue('valid', $valid, PDO::PARAM_BOOL);
				$req->execute();
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}
		}

		public function createUser($name, $login, $pass, $valid) {

			try 
			{
				$sql = "INSERT INTO " . $this->_TABLES['public']['User'] . " (name, login, pass, valid) VALUES (:name, :login, SHA1(:pass), :valid)";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('name', $name, PDO::PARAM_STR);
				$req->bindValue('login', $login, PDO::PARAM_STR);
				$req->bindValue('pass', $pass, PDO::PARAM_STR);
				$req->bindValue('valid', $valid, PDO::PARAM_BOOL);
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