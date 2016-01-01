<?php
	/**
	* 
	*/
	class Login {
		
		private $bdd;
		private $_TABLES;

		public function __construct($bdd, $_TABLES) {
			//set connector
			$this->bdd = $bdd;

			$this->_TABLES = $_TABLES;
		}

		public function getLogin($username, $password) {
			
			try 
			{
				$sql = "SELECT *
						FROM " . $this->_TABLES['public']['User'] . "
						WHERE login = :login AND pass = SHA1(:password) AND valid = :valid";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('login', $username, PDO::PARAM_STR);
				$req->bindValue('password', $password, PDO::PARAM_STR);
				$req->bindValue('valid', 1, PDO::PARAM_BOOL);
				$req->execute();
				$item = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($item) {
				return $item;
			}
			else {
				return null;
			}
		}
	}
?>