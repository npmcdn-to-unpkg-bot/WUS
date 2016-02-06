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
						WHERE email = :email AND password = SHA1(:password) AND verified = :verified AND blocked = :blocked";
				$req = $this->bdd->prepare($sql);
				$req->bindValue('email', $username, PDO::PARAM_STR);
				$req->bindValue('password', $password, PDO::PARAM_STR);
				$req->bindValue('verified', 1, PDO::PARAM_BOOL);
				$req->bindValue('blocked', 0, PDO::PARAM_BOOL);
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