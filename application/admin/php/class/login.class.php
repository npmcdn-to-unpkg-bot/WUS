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

		public function getLogin($login, $pass) {

			try 
			{
				$sql = "SELECT * 
						FROM " . $this->_TABLES['admin']['User'] . " 
			        	WHERE login = :login AND pass = SHA1(:pass) AND valid = :valid LIMIT 1";

			    $req = $this->bdd->prepare($sql);
				$req->bindValue('login', $login, PDO::PARAM_STR);
				$req->bindValue('pass', $pass, PDO::PARAM_STR);
				$req->bindValue('valid', true, PDO::PARAM_BOOL);
				$req->execute();
				$result = $req->fetch(PDO::FETCH_OBJ);
			}
			catch (PDOException $e)
			{
			    error_log($sql);
			    error_log($e->getMessage());
			    die();
			}

			if($result) {

				session_start(); 
		        $_SESSION['wus']['admin']['login'] = $result->login; 
		        $_SESSION['wus']['admin']['name'] = $result->name;
		        $_SESSION['wus']['admin']['logged'] = TRUE;
				return 1;
			}
			else {
				return 0;
			}
		}
	}
?>